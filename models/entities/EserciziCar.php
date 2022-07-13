<?php

namespace app\models\entities;

use Yii;
use PDO;


class EserciziCar extends Esercizi {

  /**
   * Set the data conclusione of the exercise
   */
  public function endExercise($idEsercizio) {
    $date = date('Y-m-d');
    $sql = "UPDATE esercizi SET data_conclusione=:dataConcl
      WHERE id=:idEser";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idEser', $idEsercizio)
      ->bindParam(':dataConcl', $date)
      ->execute();
  }

  /**
   * Gets terapia information by the esercizio id
   */
  public function getTerapiaInfoByEsercizio($idEsercizio) {
    $sql = "SELECT t.id as ter_id, t.notifiche as notifiche, l.account_email as email
      FROM terapie as t, logopedisti as l, esercizi as e
      WHERE e.id=:idEser AND t.id=e.terapia_id AND t.logopedista_id=l.id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idEser', $idEsercizio)
      ->queryOne();
  }


}

?>