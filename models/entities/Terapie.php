<?php

namespace app\models\entities;

use Yii;
use PDO;


abstract class Terapie {
  protected $idRole;

  public function __construct($idRole) {
    $this->idRole = $idRole;
  }

  /**
   * Gets all the therapies interested with the user
   */
  abstract public function getAllTerapie();


  /**
   * Gets the terapia base info by id terapia
   */
  public function getTerapiaInfoById($idTerapia) {
    $sql = "SELECT * FROM terapie WHERE id=:idTer";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->queryOne();
  }

  /**
   * Gets the utente base info by id terapia
   */
  public function getUtenteInfoByTerapia($idTerapia) {
    $sql = "SELECT u.* 
      FROM utenti as u, terapie as t
      WHERE t.utente_id=u.id AND t.id=:idTer";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->queryOne();
  }

  /**
   * Gets the questionari assegnati base info by id terapia
   */
  public function getQuestionariInfoByTerapia($idTerapia) {
    $sql = "SELECT q.* , qa.id as qa_id, qa.data_consegna as qa_datacons
      FROM questionari as q, questionariassegnati as qa
      WHERE qa.terapia_id=:idTer AND q.id=qa.questionario_id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->queryAll();
  }

  /**
   * Gets the questionari assegnatiesercizi by id terapia
   */ 
  public function getEserciziInfoByTerapia($idTerapia) {
    $sql = "SELECT * FROM esercizi WHERE terapia_id=:idTer
      ORDER BY data_assegnato DESC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->queryAll();
  }


}

?>