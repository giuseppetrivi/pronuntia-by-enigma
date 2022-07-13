<?php

namespace app\models\questionariform_hierarchy;

use Yii;
use PDO;


class QuestionarioFormCar extends QuestionarioForm {

  private $id;


  public function __construct($_caregiver, $idQuestionarioAssegnato, $array_quesiti) {
    parent::__construct($_caregiver);

    $this->__set('id', $idQuestionarioAssegnato);

    foreach ($array_quesiti as $value) {
      $id = $value['id'];
      $contenuto = $value['contenuto'];
      $this->addQuesito($id, $contenuto);
    }
  }


  public function saveQuestionario() {
    $idQuestionarioAssegnato = $this->__get('id');
    $array_quesiti = $this->getArrayQuesiti();
    $this->_roleInstance->get_questionari()->saveRisposteQuestionario($idQuestionarioAssegnato, $array_quesiti);
  }


  /**
   * Create and add quesito instance to array of quesiti
   */
  protected function addQuesito($id, $contenuto) {
    $_quesito = new QuesitoForm();
    $_quesito->__set('id', $id);
    $_quesito->__set('contenuto', $contenuto);
    array_push($this->array_quesiti, $_quesito);
  }

  
}


?>