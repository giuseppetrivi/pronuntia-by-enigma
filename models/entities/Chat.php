<?php

namespace app\models\entities;

use Yii;
use PDO;


abstract class Chat {
  protected $idRole;

  public function __construct($idRole) {
    $this->idRole = $idRole;
  }


  /**
   * Gets all the messaggi and the associate risposte (if exists)
   */
  abstract public function getAllMessaggiRisposte();


}

?>