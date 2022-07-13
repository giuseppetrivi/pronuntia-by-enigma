<?php

namespace app\models\entities;

use Yii;
use PDO;


class LogopedistiSalvatiCar extends LogopedistiSalvati {

  /**
   * Add/remove the logopedista to the table logopedistisalvati
   */
  public function addLogopedistaSalvato($idLogopedista) {
    $idCaregiver = $this->idRole;
    $sql = "INSERT INTO logopedistisalvati(caregiver_id, logopedista_id)
      VALUES (:idCar, :idLog)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }
  public function removeLogopedistaSalvato($idLogopedista) {
    $idCaregiver = $this->idRole;
    $sql = "DELETE FROM logopedistisalvati
      WHERE logopedista_id=:idLog AND caregiver_id=:idCar";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }


  public function getAllLogopedistiSalvati() {
    $idCaregiver = $this->idRole;
    $sql = "SELECT id, nome, cognome, account_email, bio , caregiver_id AS salvato
      FROM logopedistisalvati, logopedisti 
      WHERE caregiver_id=:idCar AND id=logopedista_id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->queryAll();
  }



}

?>