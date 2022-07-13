<?php

namespace app\models\entities;

use Yii;
use PDO;


class EserciziLog extends Esercizi {

  
  /**
   * Put the record of the exercise in the database
   */
  public function assignExercise($attributes) {
    $idTerapia = $attributes['idTerapia'];
    $nome_esercizio = $attributes['nome_esercizio'];
    $link = $attributes['link'];
    $data_scadenza = $attributes['data_scadenza']=='' ? null : $attributes['data_scadenza'];
    $sql = "INSERT INTO esercizi (terapia_id, nome_esercizio, link, data_scadenza)
      VALUES (:idTer, :nomeEser, :link, :dataScad)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->bindParam(':nomeEser', $nome_esercizio)
      ->bindParam(':link', $link)
      ->bindParam(':dataScad', $data_scadenza)
      ->execute();
  }




}

?>