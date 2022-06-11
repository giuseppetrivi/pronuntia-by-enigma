<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;


class RegisterCaregiverForm extends RegisterForm
{

    public $type = 'CAR';
    /**
     * Create an array with the account data
     * 
     * @override
     */
    protected function setAccountDataInArray() {
      return [
        'email' => $this->email,
        'password' => $this->getHashedPassword(),
        'tipo' => $this->type,
        'authKey' => $this->generateAuthKey(),
      ];
    }
    /**
     * Create an array with the additional info data
     * 
     * @override
     */
    protected function setRoleTableDataInArray() {
      return [
        'id' => $this->getRoleTableId(),
        'email' => $this->email,
        'nome' => $this->firstname,
        'cognome' => $this->lastname,
        'data_nascita' => $this->date_birth
      ];
    }
}
