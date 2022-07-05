<?php

namespace app\models\entities;

use Yii;
use PDO;


abstract class Appuntamenti {
  protected $idRole;

  public function __construct($idRole) {
    $this->idRole = $idRole;
  }

  /**
   * Get all the appointments of the logopedista
   */
  abstract public function getAllAppuntamenti($dates=null);



  
}

?>