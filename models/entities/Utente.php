<?php

namespace app\models\entities;

use Yii;
use PDO;


class Utente {
  private $_caregiver;

  public function __construct($_caregiver) {
    $this->_caregiver = $_caregiver;
  }


  /**
   * Get all utenti created by this caregiver
   */
  public function getAllUtentiOfCaregiver() {
    $id = $this->_caregiver->__get('id');
    $sql = "SELECT * FROM utenti 
      WHERE caregiver_id=:idCar 
      ORDER BY data_nascita DESC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryAll();
  }
}

?>