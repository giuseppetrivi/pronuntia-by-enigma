<?php

namespace app\models\questionariform_hierarchy;

use Yii;
use PDO;


class QuestionarioFormLog extends QuestionarioForm {

  private $titolo;
  private $altre_info;

  public function __construct($_logopedista, $titolo, $altre_info, $array_quesiti) {
    parent::__construct($_logopedista);

    $this->__set('titolo', $titolo);
    $this->__set('altre_info', $altre_info);

    foreach ($array_quesiti as $contenuto) {
      $this->addQuesito($contenuto);
    }
  }

  
  public function saveQuestionario() {
    $info_questionario = $this->getInfoQuestionario();
    $array_quesiti = $this->getArrayQuesiti();
    $this->_roleInstance->get_questionari()->saveQuestionarioAndQuesiti($info_questionario, $array_quesiti);
  }


  /**
   * Create and add quesito instance to array of quesiti
   */
  protected function addQuesito($contenuto) {
    $_quesito = new QuesitoForm();
    $_quesito->__set('contenuto', $contenuto);
    array_push($this->array_quesiti, $_quesito);
  }

  /**
   * Create an array with the basic info of the questionario
   */
  private function getInfoQuestionario() {
    return [
      'titolo' => $this->titolo,
      'altre_info' => $this->altre_info
    ];
  }

}


?>