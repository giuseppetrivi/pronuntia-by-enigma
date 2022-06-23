<?php

namespace app\models\entities;

use Yii;
use PDO;


class LogopedistiSalvati {
  private $idCaregiver;

  public function __construct($idCaregiver) {
    $this->idCaregiver = $idCaregiver;
  }

  /**
   * Add/remove the logopedista to the table logopedistisalvati
   */
  public function addLogopedistaSalvato($idLogopedista) {
    $id = $this->idCaregiver;
    $sql = "INSERT INTO logopedistisalvati(caregiver_id, logopedista_id)
      VALUES (:idCar, :idLog)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }
  public function removeLogopedistaSalvato($idLogopedista) {
    $id = $this->idCaregiver;
    $sql = "DELETE FROM logopedistisalvati
      WHERE logopedista_id=:idLog AND caregiver_id=:idCar";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }


  /**
   * Get all logopedisti salvati by the id of caregiver
   */
  public static function getAllLogopedistiSalvatiByCaregiver($idCaregiver) {
    $sql = "SELECT id, nome, cognome, account_email, bio , caregiver_id AS salvato
      FROM logopedistisalvati, logopedisti 
      WHERE caregiver_id=:idCar AND id=logopedista_id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->queryAll();
  }
  /**
   * Get all logopedisti salvati by the id of logopedista
   */
  public static function getAllLogopedistiSalvatiByLogopedista($idLogopedista) {
    $sql = "SELECT id, nome, cognome, account_email, caregiver_id AS salvato
      FROM logopedistisalvati, caregiver 
      WHERE logopedista_id=:idLog AND id=caregiver_id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }


}

?>