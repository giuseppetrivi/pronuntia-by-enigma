<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Exception;


/**
 * 
 */
class ContactForm extends Model
{
    private $_caregiver = null;

    public $logopedista;
    public $titolo;
    public $contenuto;


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
          'contenuto' => 'Contenuto',
          'logopedista' => 'Scegli logopedista'
      ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
              ['logopedista', 'titolo', 'contenuto'], 
              'required',
              'message' => '{attribute} non può essere vuoto'
            ],
            [
              ['titolo'], 
              'string', 
              'max' => 32,
              'tooLong' => '{attribute} è troppo lungo'
            ],
            [
              ['contenuto'], 
              'string', 
              'max' => 255,
              'tooLong' => '{attribute} è troppo lungo'
            ],
        ];
    }

    
    /**
     * Get hte model attributes and send it to the entity function
     *  to set the messaggio
     */
    public function sendMessaggio() {
      $attributes = $this->getAttributes();
      return $this->_caregiver->get_chat()->setMessaggio($attributes);
    }

}
