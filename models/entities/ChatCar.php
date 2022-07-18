<?php

namespace app\models\entities;

use Yii;
use PDO;


class ChatCar extends Chat {

  public function getAllMessaggiRisposte() {
    $idCaregiver = $this->idRole;
    $sql = "SELECT m.id, m.titolo, m.contenuto as mcon, m.data_ora as mdo, r.contenuto as rcon, 
        r.data_ora as rdo, l.nome, l.cognome
      FROM logopedisti as l JOIN messaggi as m ON l.id=m.logopedista_id 
        JOIN caregiver as c ON c.id=m.caregiver_id
        LEFT JOIN rispostemessaggi as r ON m.id=r.messaggio_id
      WHERE c.id=:idCar
      ORDER BY rdo, mdo DESC";
    
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->queryAll();
  }

  /**
   * Set the messaggio in the database
   */
  public function setMessaggio($attributes) {
    $idCaregiver = $this->idRole;
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