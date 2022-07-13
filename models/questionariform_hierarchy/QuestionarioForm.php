<?php

namespace app\models\questionariform_hierarchy;

use Yii;
use PDO;


abstract class QuestionarioForm {

  protected $_roleInstance;

  protected $array_quesiti = [];


  public function __construct($_roleInstance) {
    $this->_roleInstance = $_roleInstance;
  }


  /**
   * Getter magic method
   */
  public function __get($name) {
    if (property_exists($this, $name)) {
      return $this->$name;
    }
  }
  /**
   * Setter magic method
   */
  public function __set($name, $value) {
    if (property_exists($this, $name)) {
      $this->$name = $value;
    }
  }

  /**
   * Save the questionario and quesiti in the database
   */
  abstract public function saveQuestionario();

  
  /**
   * Create an array of all quesiti
   */
  protected function getArrayQuesiti() {
    $array_quesiti = [];
    foreach ($this->array_quesiti as $_quesito) {
      $id = $_quesito->__get('id');
      $contenuto = $_quesito->__get('contenuto');
      array_push($array_quesiti, [
        'id' => $id,
        'contenuto' => $contenuto
      ]);
    }
    return $array_quesiti;
  }


  /*
   * Verify if the questionario is valid or not
   *
  protected function isValidQuestionario() {
    if ($this->titolo!='' && count($this->array_quesiti)>0)
      return true;
    return false;
  }*/

}

?>