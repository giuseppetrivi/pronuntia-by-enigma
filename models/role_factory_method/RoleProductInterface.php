<?php

namespace app\models\role_factory_method;

use Yii;
use Exception;

abstract class RoleProductInterface {

  private $accountTableName = 'account';
  protected $roleTableName;


  public function insertInAccount(array $data) {
    try {
      Yii::$app->db->createCommand()->insert($this->accountTableName, [
        'email' => $data['email'],
        'password' => $data['password'],
        'tipo' => $data['tipo'],
        'authKey' => $data['authKey']
      ])->execute();
    } catch (Exception $e) {
      return false;
    }
    return true;
  }


  public function insertInRoleTable(array $data) {
    try {
      Yii::$app->db->createCommand()->insert($this->roleTableName, [
        'id' => $data['id'],
        'account_email' => $data['email'],
        'nome' => $data['nome'],
        'cognome' => $data['cognome'],
        'data_nascita' => $data['data_nascita']
      ])->execute();
    } catch (Exception $e) {
      return false;
    }
    return true;
  }


  abstract public function getEntityInstance($email);

  abstract public function getRoleHomePage();

}

?>