<?php

namespace app\models\entities;

use Yii;
use yii\db\ActiveRecord;
use PDO;

class Caregiver extends ActiveRecord {

  private static $tableName = 'caregiver';

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
  public function getCaregiverInfo() {
    $id = $this->__get('id');
    $sql = "SELECT * FROM caregiver WHERE id=:idCar LIMIT 1";
    $caregiver_info = Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryOne();
    return $caregiver_info;
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
   * Get all utenti created by this caregiver
   */
  public function getAllUtentiOfCaregiver() {
    $id = $this->__get('id');
    $sql = "SELECT * FROM utenti WHERE caregiver_id=:idCar ORDER BY data_nascita DESC";
    $all_utenti = Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryAll();
    return $all_utenti;
  }


  /**
   * Get utente info, catching him by id
   */
  public function getUtenteInfoById($idUtente) {
    $id = $this->__get('id');
    $sql = "SELECT * FROM utenti 
      WHERE caregiver_id=:idCar AND id=:idUte
      LIMIT 1";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->bindParam(':idUte', $idUtente)
      ->queryOne();
  }

  /**
   * Save the information of the new/modified utente
   */
  public function saveNewUtente($new_data) {
    $id = $this->__get('id');
    $sql = "INSERT INTO utenti (caregiver_id, nome, cognome, data_nascita, peso, sesso)
      VALUES (:idCar, :nome, :cognome, :dataNascita, :peso, :sesso)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':nome', $new_data['nome'])
      ->bindParam(':cognome', $new_data['cognome'])
      ->bindParam(':dataNascita', $new_data['data_nascita'])
      ->bindParam(':peso', $new_data['peso'])
      ->bindParam(':sesso', $new_data['sesso'])
      ->bindParam(':idCar', $id)
      ->execute();
  }
  public function saveModificationsUtente($modified_data) {
    $id = $this->__get('id');
    $sql = "UPDATE utenti 
      SET nome=:nome , cognome=:cognome , data_nascita=:dataNascita , 
        peso=:peso , sesso=:sesso
      WHERE caregiver_id=:idCar AND id=:idUte ";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':nome', $modified_data['nome'])
      ->bindParam(':cognome', $modified_data['cognome'])
      ->bindParam(':dataNascita', $modified_data['data_nascita'])
      ->bindParam(':peso', $modified_data['peso'])
      ->bindParam(':sesso', $modified_data['sesso'])
      ->bindParam(':idCar', $id)
      ->bindParam(':idUte', $modified_data['id'])
      ->execute();
  }


  /**
   * 
   */
  public function addLogopedistaSalvato($idLogopedista) {
    $id = $this->__get('id');
    $sql = "INSERT INTO logopedistisalvati(caregiver_id, logopedista_id)
      VALUES (:idCar, :idLog)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }
  public function removeLogopedistaSalvato($idLogopedista) {
    $id = $this->__get('id');
    $sql = "DELETE FROM logopedistisalvati
      WHERE logopedista_id=:idLog AND caregiver_id=:idCar";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }


  /**
   * Gets all the messaggi and the associate risposte (if exists)
   */
  public function getAllMessaggiRisposte() {
    $id = $this->__get('id');
    $sql = "SELECT m.id, m.titolo, m.contenuto as mcon, m.data_ora as mdo, r.contenuto as rcon, 
        r.data_ora as rdo, l.nome, l.cognome
      FROM logopedisti as l JOIN messaggi as m ON l.id=m.logopedista_id 
        JOIN caregiver as c ON c.id=m.caregiver_id
        LEFT JOIN risposte as r ON m.id=r.messaggio_id
      WHERE c.id=:idCar
      ORDER BY rdo, mdo DESC";
    
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryAll();
  }

  /**
   * Set the messaggio in the database
   */
  public function setMessaggio($attributes) {
    $idCaregiver = $this->__get('id');
    $idLogopedista = $attributes['logopedista'];
    $titolo = $attributes['titolo'];
    $contenuto = $attributes['contenuto'];
    $sql = "INSERT INTO messaggi (caregiver_id, logopedista_id, titolo, contenuto) 
      VALUES (:idCar, :idLog, :titolo, :contenuto)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->bindParam(':idLog', $idLogopedista)
      ->bindParam(':titolo', $titolo)
      ->bindParam(':contenuto', $contenuto)
      ->execute();
  }


}

?>