<?php

namespace app\models\role_factory_method;

use app\models\entities\Moderatore;


class RoleModeratore extends RoleProductInterface {

  protected $roleTableName = 'moderatori';

  public function getEntityInstance($email) {
    return Moderatore::findIdentity($email);    
  }

  public function getRoleHomePage() {
    return 'moderatore/logopedisti-list';    
  }

  public function getRegisterModelInstance() {
    return null;
  }

  public function getModifyAccountInstance($_roleInstance) {
    return null;
  }
  public function getModifyPage() {
    return '';
  }

  
}

?>