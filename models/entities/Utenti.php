<?php

namespace app\models\entities;

use Yii;
use PDO;


class Utenti {
  private $idCaregiver;

  public function __construct($idCaregiver) {
    $this->idCaregiver = $idCaregiver;
  }


  /**
   * Get all utenti created by this caregiver
   */
  public function getAllUtentiOfCaregiver() {
    $id = $this->idCaregiver;
    $sql = "SELECT * FROM utenti 
      WHERE caregiver_id=:idCar 
      ORDER BY data_nascita DESC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryAll();
  }

  /**
   * Get utente info, catching him by id
   */
  public function getUtenteInfoById($idUtente) {
    $id = $this->idCaregiver;
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
    $id = $this->idCaregiver;
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
    $id = $this->idCaregiver;
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
}

?>