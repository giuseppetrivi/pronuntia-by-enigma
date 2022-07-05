<?php

namespace app\models\entities;

use Yii;
use PDO;


class ChatLog extends Chat {

  public function getAllMessaggiRisposte() {
    $idLogopedista = $this->idRole;
    $sql = "SELECT m.id, m.titolo, m.contenuto as mcon, m.data_ora as mdo, r.contenuto as rcon, 
        r.data_ora as rdo, c.nome, c.cognome
      FROM logopedisti as l JOIN messaggi as m ON l.id=m.logopedista_id 
        JOIN caregiver as c ON c.id=m.caregiver_id
        LEFT JOIN risposte as r ON m.id=r.messaggio_id
      WHERE l.id=:idLog
      ORDER BY rdo ASC , mdo DESC";
    
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }

  /**
   * Set the messaggio in the database
   */
  public function setRisposta($attributes) {
    $idMessaggio = $attributes['idMessaggio'];
    $contenuto = $attributes['risposta'];
    $sql = "INSERT INTO risposte (messaggio_id, contenuto) 
      VALUES (:idMess, :contenuto)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idMess', $idMessaggio)
      ->bindParam(':contenuto', $contenuto)
      ->execute();
  }
}

?>