<?php

namespace app\models\entities;

use Yii;
use PDO;


abstract class Esercizi {
  protected $idRole;

  public function __construct($idRole) {
    $this->idRole = $idRole;
  }


}

?>