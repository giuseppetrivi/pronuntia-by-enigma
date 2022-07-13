<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Exception;

use app\models\entities\Logopedista;


/**
 * 
 */
class TherapyForm extends Model
{
    private $_logopedista = null;

    public $idUtente;


    public function __construct($_logopedista) {
      $this->_logopedista = $_logopedista;
    }


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
      return [
          'idUtente' => 'Utente'
      ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
      return [
        [
          ['idUtente'], 
          'required',
          'message' => '{attribute} non può essere vuoto'
        ]
      ];
    }

    
    /**
     * Start the therapy with the utente
     */
    public function startTherapy() {
      $attributes = $this->getAttributes(['idUtente']);
      return $this->_logopedista->get_terapie()->createTerapia($attributes);
    }

}
