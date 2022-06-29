<?php

namespace app\models\entities;

use app\models\modifyaccount_hierarchy\ModifyEntitiesInterface;
use Yii;
use yii\db\ActiveRecord;
use PDO;

class Caregiver extends ActiveRecord implements ModifyEntitiesInterface {

  private static $tableName = 'caregiver';

  private $_utenti = null;
  private $_chat = null;
  private $_logopedistisalvati = null;
  private $_appuntamenti = null;

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
   * Get all caregiver informations stored in database
   */
  public function getRoleAccountInfo() {
    $id = $this->__get('id');
    $sql = "SELECT * FROM caregiver WHERE id=:idCar LIMIT 1";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryOne();
  }

  /**
   * Save the modified data in the database
   */
  public function saveModification($modified_data) {
    $id = $this->__get('id');
    $sql = "UPDATE caregiver 
      SET nome=:nome , cognome=:cognome , data_nascita=:dataNascita , num_telefono=:numTel
      WHERE id=:idCar";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':nome', $modified_data['nome'])
      ->bindParam(':cognome', $modified_data['cognome'])
      ->bindParam(':dataNascita', $modified_data['data_nascita'])
      ->bindParam(':numTel', $modified_data['num_telefono'], PDO::PARAM_STR)
      ->bindParam(':idCar', $id)
      ->execute();
  }
  

  /**
   * Return (and create) an instance of class Utenti to handle utenti
   */
  public function get_utenti() {
    if ($this->_utenti==null) {
      $this->_utenti = new Utenti($this->__get('id'));
    }
    return $this->_utenti;
  }

  /**
   * Return (and create) an instance of class LogopedistiSalvati
   * to handle the logopedisti salvati
   */
  public function get_logopedistisalvati() {
    if ($this->_logopedistisalvati==null) {
      $this->_logopedistisalvati = new LogopedistiSalvati($this->__get('id'));
    }
    return $this->_logopedistisalvati;
  }

  /**
   * Return (and create) an instance of class Chat to handle utenti
   */
  public function get_chat() {
    if ($this->_chat==null) {
      $this->_chat = new Chat($this->__get('id'));
    }
    return $this->_chat;
  }

  /**
   * Return (and create) an instance of class AppuntamentiCar to handle utenti
   */
  public function get_appuntamenti() {
    if ($this->_appuntamenti==null) {
      $this->_appuntamenti = new AppuntamentiCar($this->__get('id'));
    }
    return $this->_appuntamenti;
  }


}

?>