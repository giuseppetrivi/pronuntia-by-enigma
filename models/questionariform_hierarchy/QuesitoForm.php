<?php

namespace app\models\questionariform_hierarchy;

use Yii;
use PDO;


class QuesitoForm {
  private $id;
  private $contenuto;


  public function __get($name) {
    if (property_exists($this, $name)) {
      return $this->$name;
    }
  }
  public function __set($name, $value) {
    if (property_exists($this, $name)) {
      $this->$name = $value;
    }
  }



}

?>