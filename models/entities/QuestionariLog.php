<?php

namespace app\models\entities;

use Yii;
use PDO;


class QuestionariLog extends Questionari {
  

  public function getAllQuestionari() {
    $idLogopedista = $this->idRole;
    $sql = "SELECT * FROM questionari WHERE logopedista_id=:idLog
      ORDER BY preferiti DESC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }

  public function getQuestionarioById($idQuestionario) {
    $idLogopedista = $this->idRole;
    $sql = "SELECT * FROM questionari 
      WHERE id=:idQuest AND logopedista_id=:idLog";
    $questionario_info = Yii::$app->db->createCommand($sql)
      ->bindParam(':idQuest', $idQuestionario)
      ->bindParam('idLog', $idLogopedista)
      ->queryOne();
    
    $sql = "SELECT * FROM quesiti
      WHERE questionario_id=:idQuest";
    $questionario_info['quesiti'] = Yii::$app->db->createCommand($sql)
      ->bindParam(':idQuest', $idQuestionario)
      ->queryAll();
    
    return $questionario_info;
  }
  
  /**
   * Save / unsave a questionario to preferiti
   */
  public function saveToPreferiti($idQuestionario, $preferito) {
    $preferito = $preferito==1 ? 0 : 1;
    $idLogopedista = $this->idRole;
    $sql = "UPDATE questionari SET preferiti=:preferito
      WHERE id=:idQuest AND logopedista_id=:idLog";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':preferito', $preferito)
      ->bindParam(':idQuest', $idQuestionario)
      ->bindParam(':idLog', $idLogopedista)
      ->execute();
  }


  /**
   * Save the questionario and the quesiti in the database
   */
  public function saveQuestionarioAndQuesiti($info_questionario, $array_quesiti) {
    $idLogopedista = $this->idRole;
    $titolo = $info_questionario['titolo'];
    $altre_info = $info_questionario['altre_info'];

    $sql = "INSERT INTO questionari (logopedista_id, titolo, altre_info)
      VALUES (:idLog, :titolo, :altreInfo)";
    Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->bindParam(':titolo', $titolo)
      ->bindParam(':altreInfo', $altre_info)
      ->execute();
    
    $idQuestionario = Yii::$app->db->lastInsertID;
    
    foreach ($array_quesiti as $quesito) {
      $contenuto = $quesito['contenuto'];
      $sql = "INSERT INTO quesiti (questionario_id, quesito)
        VALUES (:idQuest, :contenuto)";
      Yii::$app->db->createCommand($sql)
        ->bindParam(':idQuest', $idQuestionario)
        ->bindParam(':contenuto', $contenuto)
        ->execute();
    }
  }


  /**
   * Set the questionario in the questionariassegnati table to a caregiver
   */
  public function assignQuestionnaire($attributes) {
    $idTerapia = $attributes['idTerapia'];
    $idQuestionario = $attributes['idQuestionario'];
    $sql = "INSERT INTO questionariassegnati(terapia_id, questionario_id)
      VALUES (:idTer, :idQuest)";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idTer', $idTerapia)
      ->bindParam(':idQuest', $idQuestionario)
      ->execute();
  }


  /**
   * Gets questionario info by his id
   */
  public function getQuestionarioAssegnatoById($idQuestionarioAssegnato) {
    $sql = "SELECT q.id, q.titolo, q.altre_info, 
        qa.data_assegnazione, qa.data_consegna
      FROM questionariassegnati as qa, questionari as q
      WHERE qa.questionario_id=q.id AND qa.id=:idQuest";
    $questionario_info = Yii::$app->db->createCommand($sql)
      ->bindParam(':idQuest', $idQuestionarioAssegnato)
      ->queryOne();
    
    $sql = "SELECT q.id, q.quesito, rq.risposta
      FROM quesiti as q, rispostequesiti as rq
      WHERE rq.quesito_id=q.id AND rq.questionarioassegnato_id=:idQuest";
    $questionario_info['quesiti'] = Yii::$app->db->createCommand($sql)
      ->bindParam(':idQuest', $idQuestionarioAssegnato)
      ->queryAll();
    
    return $questionario_info;
  }



}

?>