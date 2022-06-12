<?php

namespace app\models\registerform_hierarchy;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;


class RegisterLogopedistaForm extends RegisterForm
{
    public $type = 'LOG';
    public $info_to_confirm;


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
      $array_of_labels = parent::attributeLabels();
      $array_of_labels['info_to_confirm'] = 'Info di conferma';
      return $array_of_labels;
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $array_of_rules = parent::rules();
        array_push($array_of_rules, [
          'info_to_confirm', 
          'string', 
          'max' => 255,
          'tooLong' => '{attribute} è troppo lungo'
        ]);
        array_push($array_of_rules, [
          'info_to_confirm',
          'required',
          'message' => '{attribute} non può essere vuoto'
        ]);
        return $array_of_rules;
    }

    /**
     * Function to validate the info to confirm the presence of the
     * logopedista in the system
     */
    public function validateInfoToConfirm() {
      if ($this->type=='LOG') {
        if (!$this->info_to_confirm) {
          $this->addError('info_to_confirm', 'Questo campo non può essere vuoto');
        }
      }
    }



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
        'data_nascita' => $this->date_birth,
        'info_per_conferma' => $this->info_to_confirm
      ];
    }
}
