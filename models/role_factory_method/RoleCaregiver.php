<?php

namespace app\models\role_factory_method;

use app\models\entities\Caregiver;


class RoleCaregiver extends RoleProductInterface {

  protected $roleTableName = 'caregiver';

  public function getEntityInstance($email) {
    return Caregiver::findIdentity($email);    
  }

  public function getRoleHomePage() {
    return 'caregiver/account';    
  }
}

?>