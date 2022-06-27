<?php

namespace app\models\role_factory_method;

use app\models\entities\Logopedista;
use app\models\modifyaccount_hierarchy\ModifyLogopedistaForm;
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

  public function getModifyAccountInstance($_roleInstance) {
    return new ModifyLogopedistaForm($_roleInstance);
  }
  public function getModifyPage() {
    return 'modify-account-logopedista';
  }

}

?>