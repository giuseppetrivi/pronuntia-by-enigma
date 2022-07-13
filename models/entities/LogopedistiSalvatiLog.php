<?php

namespace app\models\entities;

use Yii;
use PDO;


class LogopedistiSalvatiLog extends LogopedistiSalvati {

  public function getAllLogopedistiSalvati() {
    $idLogopedista = $this->idRole;
    $sql = "SELECT id, nome, cognome, account_email, caregiver_id AS salvato
      FROM logopedistisalvati, caregiver 
      WHERE logopedista_id=:idLog AND id=caregiver_id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }


  /**
   * Get info about the utenti of a specific caregiver
   */
  public function getAllCaregiverUtenti() {
    $idLogopedista = $this->idRole;
    $sql = "SELECT c.nome as car_nome, c.cognome as car_cognome, 
        u.id, u.nome, u.cognome, u.data_nascita
      FROM logopedistisalvati as l, caregiver as c, utenti as u
      WHERE l.logopedista_id=:idLog AND u.caregiver_id=c.id AND c.id=l.caregiver_id
      ORDER BY c.id, car_nome, car_cognome ASC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }



}

?>