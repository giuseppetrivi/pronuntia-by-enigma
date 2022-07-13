<?php

namespace app\models\entities;

use Yii;
use PDO;


class TerapieLog extends Terapie {

  public function getAllTerapie() {
    $idLogopedista = $this->idRole;
    $sql = "SELECT c.nome as car_nome, c.cognome as car_cognome, u.id as utente_id,
        u.nome, u.cognome, u.data_nascita, u.sesso, t.data_inizio, t.data_fine,
        t.data_fine, t.id as terapia_id, t.notifiche
      FROM terapie as t, utenti as u, caregiver as c
      WHERE t.utente_id=u.id AND u.caregiver_id=c.id AND t.logopedista_id=:idLog
      ORDER BY t.data_fine ASC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }
  
  
  /**
   * Create in the database the new terapia
   */
  public function createTerapia($attributes) {
    $idUtente = $attributes['idUtente'];
    $idLogopedista = $this->idRole;
    $sql = "INSERT INTO terapie (logopedista_id, utente_id)
      VALUES (:idLog, :idUte)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->bindParam(':idUte', $idUtente)
      ->execute();
  }

  /**
   * Terminate terapia
   */
  public function terminateTerapia($idTerapia) {
    $date = date('Y-m-d');
    $sql = "UPDATE terapie SET data_fine=:dataFine
      WHERE id=:idTer";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':dataFine', $date)
      ->bindParam(':idTer', $idTerapia)
      ->execute();
  }

  /**
   * Set / unset the notifications on a specific therapy
   */
  public function changeNotificationState($idTerapia, $notifiche) {
    $notifiche = $notifiche==0 ? 1 : 0;
    $sql = "UPDATE terapie SET notifiche=:notifiche WHERE id=:idTer";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':notifiche', $notifiche)
      ->bindParam(':idTer', $idTerapia)
      ->execute();
  }


  /**
   * Gets the caregiver base info by id terapia
   */
  public function getCaregiverInfoByTerapia($idTerapia) {
    $sql = "SELECT c.* 
      FROM caregiver as c, utenti as u, terapie as t
      WHERE t.utente_id=u.id AND u.caregiver_id=c.id AND t.id=:idTer";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->queryOne();
  }


}

?>