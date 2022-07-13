<?php

namespace app\models\entities;

use Yii;
use PDO;


class QuestionariCar extends Questionari {
  

  public function getAllQuestionari() {
    $idLogopedista = $this->idRole;
    $sql = "SELECT * FROM questionari WHERE logopedista_id=:idLog
      ORDER BY preferiti DESC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }



  public function getQuestionarioById($idQuestionario) {
    $sql = "SELECT * FROM questionari 
      WHERE id=:idQuest";
    $questionario_info = Yii::$app->db->createCommand($sql)
      ->bindParam(':idQuest', $idQuestionario)
      ->queryOne();
    
    $sql = "SELECT * FROM quesiti
      WHERE questionario_id=:idQuest";
    $questionario_info['quesiti'] = Yii::$app->db->createCommand($sql)
      ->bindParam(':idQuest', $idQuestionario)
      ->queryAll();
    
    return $questionario_info;
  }

  /**
   * Gets all info of a questionario assegnato
   */
  public function getQuestionarioAssegnatoInfo($idQuestionarioAssegnato) {
    $sql = "SELECT q.* FROM questionariassegnati as qa, questionari as q
      WHERE qa.id=:idQA AND q.id=qa.questionario_id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idQA', $idQuestionarioAssegnato)
      ->queryOne();
  }

  /**
   * Save the risposte in the database
   */
  public function saveRisposteQuestionario($idQuestionarioAssegnato, $array_quesiti) {
    $datetime = date('Y-m-d h:i:s');
    $sql = "UPDATE questionariassegnati SET data_consegna=:dataConsegna
      WHERE id=:idQuest";
    Yii::$app->db->createCommand($sql)
      ->bindParam(':dataConsegna', $datetime)
      ->bindParam('idQuest', $idQuestionarioAssegnato)
      ->execute();

    foreach ($array_quesiti as $risposta) {
      $idQuesito = $risposta['id'];
      $contenuto = $risposta['contenuto'];
      $sql = "INSERT INTO rispostequesiti (questionarioassegnato_id, quesito_id, risposta)
        VALUES (:idQuest, :idQuesito, :contenuto)";
      Yii::$app->db->createCommand($sql)
        ->bindParam(':idQuest', $idQuestionarioAssegnato)
        ->bindParam(':idQuesito', $idQuesito)
        ->bindParam(':contenuto', $contenuto)
        ->execute();
    }
  }



}

?>