<?php

namespace app\models\role_factory_method;

use app\models\entities\Logopedista;
use app\models\registerform_hierarchy\RegisterLogopedistaForm;

class RoleLogopedista extends RoleProductInterface {

  protected $roleTableName = 'logopedisti';


  public function getEntityInstance($email) {
      return Logopedista::findIdentity($email);
  }

  public function getRoleHomePage() {
    return 'site/index';    
  }

  public function getRegisterModelInstance() {
    return new RegisterLogopedistaForm();
  }

}

?>