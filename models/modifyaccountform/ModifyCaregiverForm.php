<?php

namespace app\models\modifyaccountform;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;
use Exception;


/**
 * 
 */
class ModifyCaregiverForm extends Model implements ModifyAccountInterface
{
    private $_caregiver = null;

    public $nome;
    public $cognome;
    public $data_nascita;
    public $num_telefono;


    public function __construct($_caregiver) {
      $this->_caregiver = $_caregiver;
      $this->setDefaultDataInModel();
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
          'num_telefono' => 'Numero di telefono'
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
              ['nome', 'cognome', 'data_nascita'], 
              'required',
              'message' => '{attribute} non può essere vuoto'
            ],
            //check firstname and lastname length
            [
              ['nome', 'cognome'], 
              'string', 
              'max' => 63,
              'tooLong' => '{attribute} è troppo lungo'
            ],
            //validate the date of birth
            [
              'data_nascita', 
              'date', 
              'format' => 'php:Y-m-d',
              'message' => 'Formato non valido'
            ],
            //check num telefono
            [
              'num_telefono', 
              'integer',
              'message' => '{attribute} non è valido'
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
    private function setDefaultDataInModel() {
      $caregiver_info = $this->_caregiver->getCaregiverInfo();

      if (count($caregiver_info)===0) {
        throw new Exception();
      }

      $this->nome = $caregiver_info['nome'];
      $this->cognome = $caregiver_info['cognome'];
      $this->data_nascita = $caregiver_info['data_nascita'];
      $this->num_telefono = $caregiver_info['num_telefono'];
    }

    /**
     * Save the right attributes in in the database
     */
    public function saveData() {
      $modified_data = $this->getAttributes([
        'nome', 'cognome', 'data_nascita', 'num_telefono'
      ]);
      return $this->_caregiver->saveModification($modified_data);
    }

}
