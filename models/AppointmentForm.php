<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Exception;

use app\models\entities\Logopedista;


/**
 * 
 */
class AppointmentForm extends Model
{
    private $_caregiver = null;

    public $logopedista;
    public $data;
    public $ora;
    public $info = null;


    public function __construct($_caregiver) {
      $this->_caregiver = $_caregiver;
    }


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
      return [
          'titolo' => 'Titolo',
          'data' => 'Giorno',
          'ora' => 'Orario'
      ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
              ['logopedista', 'data', 'ora'], 
              'required',
              'message' => '{attribute} non può essere vuoto'
            ],
            [
              'data',
              'validateData'
            ],
            [
              'ora',
              'validateOra'
            ],
            [
              'ora',
              'validateDatetime'
            ],
            [
              ['info'], 
              'string', 
              'max' => 255,
              'tooLong' => '{attribute} è troppo lungo'
            ],
        ];
    }

    public function validateData($attribute) {
      $nameOfDay = date('l', strtotime($this->data));
      if ($nameOfDay=='Sunday' || $nameOfDay=='Saturday') {
        $this->addError($attribute, 'Non puoi selezionare i giorni festivi');
      }

      if (strtotime($this->data) < strtotime(date('Y-m-d'))) {
        $this->addError($attribute, 'Data non valida');
      }
      //date festivita altre
    }

    public function validateOra($attribute) {
      $minutes = (int) date('i', strtotime($this->ora));
      if ($minutes%10!=0) {
        $this->addError($attribute, 'Orario non valido, solo minuti multipli di 10');
      }

      $_logopedista = Logopedista::findById($this->logopedista);
      $inizio_ora = $_logopedista->__get('inizio_ora');
      $fine_ora = $_logopedista->__get('fine_ora');
      if ( (strtotime($this->ora) < strtotime($inizio_ora)) || (strtotime($this->ora) > strtotime($fine_ora)) ) {
        $this->addError($attribute, 'L\'orario inserito è fuori dall\'orario di lavoro');
      }
    }

    public function validateDatetime($attribute) {
      $datetime = $this->data . ' ' . $this->ora;
      if ($this->_caregiver->get_appuntamenti()->existAppointment($datetime, $this->logopedista)) {
        $this->addError($attribute, 'Questo orario in questa data è già prenotato');
      }
    }



    
    /**
     * Gets the attributes of the form and send it to the db functions
     */
    public function saveAppointment() {
      $attributes = $this->getAttributes();
      return $this->_caregiver->get_appuntamenti()->saveAppointment($attributes);
    }

}
