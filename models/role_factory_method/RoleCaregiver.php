<?php

namespace app\models\role_factory_method;

use app\models\entities\Caregiver;
use app\models\modifyaccount_hierarchy\ModifyCaregiverForm;
use app\models\registerform_hierarchy\RegisterCaregiverForm;

class RoleCaregiver extends RoleProductInterface {

  protected $roleTableName = 'caregiver';

  public function getEntityInstance($email) {
    return Caregiver::findIdentity($email);    
  }

  public function getRoleHomePage() {
    return 'caregiver/therapy';    
  }

  public function getRegisterModelInstance() {
    return new RegisterCaregiverForm();
  }

  public function getModifyAccountInstance($_roleInstance) {
    return new ModifyCaregiverForm($_roleInstance);
  }
  public function getModifyPage() {
    return 'modify-account-caregiver';
  }
}

?>