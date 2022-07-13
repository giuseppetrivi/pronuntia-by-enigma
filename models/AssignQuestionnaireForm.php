<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Exception;

use app\models\entities\Logopedista;


/**
 * 
 */
class AssignQuestionnaireForm extends Model
{
    private $_logopedista = null;

    public $idTerapia;
    public $idQuestionario;


    public function __construct($_logopedista) {
      $this->_logopedista = $_logopedista;
    }


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
      return [
          'idTerapia' => 'Terapia',
          'idQuestionario' => 'Questionario'
      ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
      return [
        [
          ['idTerapia', 'idQuestionario'], 
          'required',
          'message' => '{attribute} non può essere vuoto'
        ]
      ];
    }

    
    /**
     * Assign questionnaire to the terapia
     */
    public function assignQuestionnaire() {
      $attributes = $this->getAttributes(['idTerapia', 'idQuestionario']);
      return $this->_logopedista->get_questionari()->assignQuestionnaire($attributes);
    }

}
