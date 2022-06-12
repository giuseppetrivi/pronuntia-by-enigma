<?php

namespace app\models\entities;

use Yii;
use yii\db\ActiveRecord;

class Moderatore extends ActiveRecord {

  private static $tableName = 'moderatori';

  public static function tableName() {
    return '{{'.self::$tableName.'}}';
  }


  /**
   * {@inheritdoc}
   */
  public static function findIdentity($id) {
    return static::findOne(['account_email' => $id]);
  }


  /**
   * Getter class for attribute $cod_dipendente
   */
  public function getCodDipendente() {
    return $this->cod_dipendente;
  }


  /**
   * Get some info about logopedisti to confirm registration
   * 
   * @return array
   */
  public function getLogopedistiToConfirm() {
    $query = "SELECT id, cognome, nome, data_registrazione FROM logopedisti WHERE confermato IS NULL AND
      id NOT IN (
        SELECT logopedista_id AS id FROM logopedistirespinti WHERE data_risposta IS NULL
      ) ORDER BY data_registrazione ASC";
    $logopedistiToConfirm = Yii::$app->db->createCommand($query)
      ->queryAll();
    
    return $logopedistiToConfirm;
  }


  /**
   * Get all info about a logopedista by his id
   * 
   * @return array
   */
  public function getLogopedistaInfoById($id) {
    $query = "SELECT * FROM logopedisti 
      WHERE id=:idLog LIMIT 1";
    
    $logopedistaInfo = Yii::$app->db->createCommand($query)
      ->bindParam(':idLog', $id)
      ->queryOne();
    
    return $logopedistaInfo;
  }

  /**
   * Get all info about a logopedista by his id
   * 
   * @return array
   */
  public function getRejectionInfoByLogopedistaId($id) {
    $cod_dipendente = $this->getCodDipendente();
    $query = "SELECT * FROM logopedistirespinti 
      WHERE moderatore_cod_dipendente=:codDipendente AND logopedista_id=:idLog 
      ORDER BY data DESC";
    
    $rejectionInfo = Yii::$app->db->createCommand($query)
      ->bindParam(':idLog', $id)
      ->bindParam(':codDipendente', $cod_dipendente)
      ->queryAll();
    
    return $rejectionInfo;
  }


  /**
   * Confirm the registration of the logopedista
   */
  public function acceptLogopedista($idLogopedista) {
    $query = "UPDATE logopedisti SET confermato=1 
      WHERE id=:idLog";
    return Yii::$app->db->createCommand($query)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }
  /**
   * Reject the registration of the logopedista
   */
  public function rejectLogopedista($idLogopedista, $motivo) {
    $cod_dipendente = $this->getCodDipendente();
    $query = "INSERT INTO logopedistirespinti (motivo, moderatore_cod_dipendente, logopedista_id)
      VALUES ( :motivo , :cod_dipendente , :idLog )";
    return Yii::$app->db->createCommand($query)
      ->bindParam(':motivo', $motivo)
      ->bindParam(':cod_dipendente', $cod_dipendente)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();   
  }
  /**
   * Refuse the registration of the logopedista
   */
  public function denyLogopedista($idLogopedista) {
    $query = "UPDATE logopedisti SET confermato=0 
      WHERE id=:idLog";
    return Yii::$app->db->createCommand($query)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }



}

?>