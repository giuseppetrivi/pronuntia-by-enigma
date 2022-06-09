<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;

/**
 * RegisterForm is the model behind the register form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    private $id = null;

    public $email;
    public $password;
    public $type = 'LOG';
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
            // username and password are both required
            [
              ['email', 'password', 'type', 'firstname', 'lastname', 'date_birth'], 
              'required',
              'message' => '{attribute} non può essere vuoto'
            ],
            //format and check email
            ['email', 'trim'],
            ['email', 'email', 'message' => '{attribute} non valido'],
            // password is validated by validatePassword()
            [
              'password', 
              'string', 
              'max' => 127,
              'tooLong' => '{attribute} è troppo lunga'
            ],
            //check firstname and lastname length
            [
              ['firstname', 'lastname'], 
              'string', 
              'max' => 63,
              'tooLong' => '{attribute} è troppo lungo'
            ],
            //validate the date of birth
            [
              'date_birth', 
              'date', 
              'format' => 'php:Y-m-d',
              'message' => 'Formato non valido'
            ]
        ];
    }



    /**
     * Register a user using the provided data.
     * @return bool whether the user is registered in successfully
     */
    public function register() {

      $accountData = $this->setAccountDataInArray();
      $roleTableData = $this->setRoleTableDataInArray();

      $_roleHandler = RoleCreator::getInstance($this->type);
      if ($_roleHandler) {
        return $_roleHandler->insertInAccount($accountData) 
          && $_roleHandler->insertInRoleTable($roleTableData);
      }
      return false;

    }



    /**
     * Create an array with the account data
     */
    private function setAccountDataInArray() {
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
    private function setRoleTableDataInArray() {
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
    private function getRoleTableId() {
      if ($this->id == null) {
        $this->id = Yii::$app->security->generatePasswordHash($this->email);
      }
      return $this->id;
    }


    /**
     * Make a secure password by hashing the raw password
     */
    private function getHashedPassword() {
      $hashedPassword = Yii::$app->security->generatePasswordHash($this->password);
      $this->password = '';
      return $hashedPassword;
    }

    /**
     * Generate a string for the authentication
     */
    private function generateAuthKey() {
      return Yii::$app->security->generateRandomString();
    }
}
