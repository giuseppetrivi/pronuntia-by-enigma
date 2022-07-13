<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Exception;

use app\models\entities\Logopedista;


/**
 * 
 */
class AssignExerciseForm extends Model
{
    private $_logopedista = null;

    public $idTerapia;
    public $nome_esercizio;
    public $link;
    public $data_scadenza;


    public function __construct($_logopedista, $idTerapia) {
      $this->_logopedista = $_logopedista;
      $this->idTerapia = $idTerapia;
    }


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
      return [
          'idTerapia' => 'Terapia',
          'nome_esercizio' => 'Nome dell\'esercizio',
          'link' => 'Link all\'esercizio',
          'data_scadenza' => 'Scadenza per consegna esercizio'
      ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
      return [
        [
          ['idTerapia', 'nome_esercizio', 'link'], 
          'required',
          'message' => '{attribute} non può essere vuoto'
        ],
        [
          ['nome_esercizio'], 
          'string', 
          'max' => 64,
          'tooLong' => '{attribute} è troppo lungo'
        ],
        [
          ['link'], 
          'string', 
          'max' => 255,
          'tooLong' => '{attribute} è troppo lungo'
        ],
        ['data_scadenza', 'validateData']
      ];
    }

    public function validateData($attribute, $params) {
      $today = date('Y-m-d');
      if ($this->data_scadenza!='' 
        && (strtotime($this->data_scadenza) < strtotime($today)) ) {
        $this->addError($attribute, 'La data di scadenza non può essere nel passato');
      }
    }

    
    /**
     * Assign exercise to the terapia
     */
    public function assignExercise() {
      $attributes = $this->getAttributes();
      return $this->_logopedista->get_esercizi()->assignExercise($attributes);
    }

}
