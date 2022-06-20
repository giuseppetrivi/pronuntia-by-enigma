<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;
use Exception;


/**
 * Per l'aggiunta e per la modifica
 */
class UtenteForm extends Model
{
    private $_caregiver = null;

    public $nome;
    public $cognome;
    public $data_nascita;
    public $peso;
    public $sesso;


    public function __construct($_caregiver) {
      $this->_caregiver = $_caregiver;
    }


    /**
     * Set custom labels for the attributes
     * @return array the attribute labels
     */
    public function attributeLabels() {
      return [
          'nome' => 'Nome',
          'cognome' => 'Cognome',
          'data_nascita' => 'Data di nascita',
          'peso' => 'Peso (kg)',
          'sesso' => 'Sesso'
      ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
              ['nome', 'cognome', 'data_nascita', 'peso', 'sesso'], 
              'required',
              'message' => '{attribute} non può essere vuoto'
            ],
            [
              ['nome', 'cognome'], 
              'string', 
              'max' => 63,
              'tooLong' => '{attribute} è troppo lungo'
            ],
            [
              'data_nascita', 
              'date', 
              'format' => 'php:Y-m-d',
              'message' => 'Formato non valido'
            ],
            [
              'peso', 
              'number',
              'max' => 600,
              'message' => '{attribute} è troppo lungo'
            ],
        ];
    }

    
    /**
     * Check if there are differences between the form data and the model data
     */
    public function differencesBetweenData($request_data) {
      $model_attributes = $this->getAttributes();
      return count(array_diff_assoc($model_attributes, $request_data))==0 ? false : true;
    }
  

    /**
     * Set the attributes with the value of the data in caregiver instance
     */
    public function setDefaultDataInModel($idUtente) {
      $utente_info = $this->_caregiver->getUtenteInfoById($idUtente);

      if (count($utente_info)===0) {
        throw new Exception();
      }

      $this->nome = $utente_info['nome'];
      $this->cognome = $utente_info['cognome'];
      $this->data_nascita = $utente_info['data_nascita'];
      $this->peso = $utente_info['peso'];
      $this->sesso = $utente_info['sesso'];
    }

    /**
     * Save the right attributes in in the database
     */
    public function saveNewData() {
      $new_data = $this->getAttributes();
      return $this->_caregiver->saveNewUtente($new_data);
    }
    public function saveModifyData($idUtente) {
      $modified_data = $this->getAttributes();
      $modified_data['id'] = $idUtente;
      return $this->_caregiver->saveModificationsUtente($modified_data);
    }

}
