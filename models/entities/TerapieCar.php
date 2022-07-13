<?php

namespace app\models\entities;

use Yii;
use PDO;


class TerapieCar extends Terapie {

  
  public function getAllTerapie() {
    $idCaregiver = $this->idRole;
    $sql = "SELECT l.nome as log_nome, l.cognome as log_cognome, u.id as utente_id,
        u.nome, u.cognome, u.data_nascita, u.sesso, t.data_inizio, t.data_fine,
        t.data_fine, t.id as terapia_id
      FROM terapie as t, utenti as u, logopedisti as l
      WHERE t.utente_id=u.id AND u.caregiver_id=:idCar AND t.logopedista_id=l.id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->queryAll();
  }

  /**
   * Gets the logopedista base info by id terapia
   */
  public function getLogopedistaInfoByTerapia($idTerapia) {
    $sql = "SELECT l.* 
      FROM logopedisti as l, terapie as t
      WHERE t.logopedista_id=l.id AND t.id=:idTer";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->queryOne();
  }




}

?>