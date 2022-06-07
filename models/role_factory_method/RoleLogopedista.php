<?php

namespace app\models\role_factory_method;

use app\models\entities\Logopedista;


class RoleLogopedista extends RoleProductInterface {

  protected $roleTableName = 'logopedisti';


  public function getEntityInstance($email) {
      return new Logopedista($email);
  }

}

?>