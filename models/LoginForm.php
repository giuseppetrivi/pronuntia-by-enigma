<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Account|null $_user
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
        return [
            'rememberMe' => 'Ricordati  di me'
        ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['email', 'password'], 
                'required',
                'message' => '{attribute} non può essere vuoto'
            ],
            ['email', 'trim'],
            ['email', 'email', 'message' => '{attribute} non valido'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Email o password errati.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return Account|null
     */
    private function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Account::findByEmail($this->email);
        }

        return $this->_user;
    }
}
