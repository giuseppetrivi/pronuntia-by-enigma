<?php

namespace app\models\entities;

use Yii;
use PDO;


abstract class Questionari {
  protected $idRole;

  public function __construct($idRole) {
    $this->idRole = $idRole;
  }

  /**
   * Get all the questionari of the logopedista
   */
  abstract public function getAllQuestionari();

  /**
   * Gets questionario info by his id
   */
  abstract public function getQuestionarioById($idQuestionario);

}

?>