<?php

namespace app\models\registerform_hierarchy;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;


/**
 * 
 */
abstract class RegisterForm extends Model
{
    private $id = null;

    public $email;
    public $password;
    public $type;
    public $firstname;
    public $lastname;
    public $date_birth;


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
      return [
          'email' => 'Indirizzo email',
          'password' => 'Password',
          'type' => 'Tipo di registrazione',
          'firstname' => 'Nome',
          'lastname' => 'Cognome',
          'date_birth' => 'Data di nascita'
      ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
              ['email', 'password', 'type', 'firstname', 'lastname', 'date_birth'], 
              'required',
              'message' => '{attribute} non può essere vuoto'
            ],
            ['email', 'trim'],
            ['email', 'email', 'message' => '{attribute} non valido'],
            ['email', 'validateEmail', 'skipOnEmpty' => false, 'skipOnError' => false],
            [
              'password', 
              'string', 
              'max' => 127,
              'tooLong' => '{attribute} è troppo lunga'
            ],
            [
              ['firstname', 'lastname'], 
              'string', 
              'max' => 63,
              'tooLong' => '{attribute} è troppo lungo'
            ],
            [
              'date_birth', 
              'date', 
              'format' => 'php:Y-m-d',
              'message' => 'Formato non valido'
            ],
        ];
    }


    /**
     * Validates the email.
     * This method serves as the inline validation for email.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmail($attribute, $params)
    {
      if (!$this->hasErrors()) {
        $results = Yii::$app->db->createCommand("SELECT email FROM account WHERE email=:email")
          ->bindParam(':email', $this->email)
          ->queryAll();

        if (count($results)>0) {
          $this->addError($attribute, 'Indirizzo email già registrato.');
        }
      }
    }


    /**
     * Register a user using the provided data.
     * @return bool whether the user is registered in successfully
     */
    public function register() {
      if ($this->validate()) {
        $accountData = $this->setAccountDataInArray();
        $roleTableData = $this->setRoleTableDataInArray();
  
        $_roleHandler = RoleCreator::getInstance($this->type);
        if ($_roleHandler) {
          return $_roleHandler->insertInAccount($accountData) 
            && $_roleHandler->insertInRoleTable($roleTableData);
        }
        return false;
      }
    }



    /**
     * Create an array with the account data
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
     */
    protected function setRoleTableDataInArray() {
      return [
        'id' => $this->getRoleTableId(),
        'email' => $this->email,
        'nome' => $this->firstname,
        'cognome' => $this->lastname,
        'data_nascita' => $this->date_birth,
      ];
    }


    /**
     * Get (and set if null) the role table id
     */
    protected function getRoleTableId() {
      if ($this->id == null) {
        $this->id = Yii::$app->security->generatePasswordHash($this->email);
      }
      return $this->id;
    }


    /**
     * Make a secure password by hashing the raw password
     */
    protected function getHashedPassword() {
      $hashedPassword = Yii::$app->security->generatePasswordHash($this->password);
      $this->password = '';
      return $hashedPassword;
    }

    /**
     * Generate a string for the authentication
     */
    protected function generateAuthKey() {
      return Yii::$app->security->generateRandomString();
    }
}
