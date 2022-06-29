<?php

namespace app\models\entities;

use Yii;
use PDO;


class AppuntamentiCar {
  private $idCaregiver;

  public function __construct($idCaregiver) {
    $this->idCaregiver = $idCaregiver;
  }


  /**
   * Get all the appointments of the caregiver
   */
  public function getAllAppuntamenti() {
    $idCaregiver = $this->idCaregiver;
    $sql = "SELECT a.id, a.data_ora, a.info, l.nome, l.cognome
      FROM appuntamenti as a, logopedisti as l
      WHERE a.logopedista_id=l.id AND a.caregiver_id=:idCar
      ORDER BY a.data_ora DESC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->queryAll();
  }


  /**
   * Get the appointment by the datetime
   * @return bool
   */
  public function existAppointment($datetime, $idLogopedista) {
    $sql = "SELECT id FROM appuntamenti
      WHERE data_ora=:dataOra AND logopedista_id=:idLog";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':dataOra', $datetime)
      ->bindParam(':idLog', $idLogopedista)
      ->queryOne();
  }


  /**
   * Save the appointment in the database
   */
  public function saveAppointment($attributes) {
    $idCaregiver = $this->idCaregiver;
    $idLogopedista = $attributes['logopedista'];
    $info = $attributes['info']=='' ? null : $attributes['info'];
    $data = $attributes['data'];
    $ora = $attributes['ora'];
    $dataOra = $data .' '. $ora;
    $sql = "INSERT INTO appuntamenti(logopedista_id, caregiver_id, data_ora, info)
      VALUES (:idLog, :idCar, :dataOra, :info)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->bindParam(':idCar', $idCaregiver)
      ->bindParam(':dataOra', $dataOra)
      ->bindParam(':info', $info)
      ->execute();
  }

  /**
   * Remove the appointment from the database
   */
  public function cancelAppointment($idAppuntamento) {
    $sql = "DELETE FROM appuntamenti WHERE id=:idApp";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idApp', $idAppuntamento)
      ->execute();
  }



  
}

?>