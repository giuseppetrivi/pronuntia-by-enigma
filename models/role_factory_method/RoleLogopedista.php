<?php

namespace app\models\role_factory_method;

use Yii;
use Exception;

use app\models\entities\Logopedista;
use app\models\modifyaccount_hierarchy\ModifyLogopedistaForm;
use app\models\registerform_hierarchy\RegisterLogopedistaForm;

class RoleLogopedista extends RoleProductInterface {

  protected $roleTableName = 'logopedisti';

  public function insertInRoleTable(array $data) {
    try {
      Yii::$app->db->createCommand()->insert($this->roleTableName, [
        'id' => $data['id'],
        'account_email' => $data['email'],
        'nome' => $data['nome'],
        'cognome' => $data['cognome'],
        'data_nascita' => $data['data_nascita'],
        'info_per_conferma' => $data['info_per_conferma']
      ])->execute();
    } catch (Exception $e) {
      return false;
    }
    return true;
  }


  public function getEntityInstance($email) {
      return Logopedista::findIdentity($email);
  }

  public function getRoleHomePage() {
    return 'logopedista/therapy';    
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