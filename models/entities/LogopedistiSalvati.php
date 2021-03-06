<?php

namespace app\models\entities;

use Yii;
use PDO;


abstract class LogopedistiSalvati {
  protected $idRole;

  public function __construct($idRole) {
    $this->idRole = $idRole;
  }


  /**
   * Get all logopedisti salvati
   */
  abstract public function getAllLogopedistiSalvati();


}

?>