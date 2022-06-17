<?php

namespace app\models\modifyaccountform;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;
use Exception;


/**
 * 
 */
class ModifylogopedistaForm extends Model implements ModifyAccountInterface
{
    private $_logopedista = null;

    public $nome;
    public $cognome;
    public $data_nascita;
    public $altre_info;


    public function __construct($_logopedista) {
      $this->_logopedista = $_logopedista;
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
          'altre_info' => 'Altre informazioni'
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
        ];
    }
  

    public function setDefaultDataInModel() {
      $logopedista_info = $this->_logopedista->getLogopedistaInfo();

      if (count($logopedista_info)===0) {
        throw new Exception();
      }

      $this->setAttributes([
        'nome' => $logopedista_info['nome'],
        'cognome' => $logopedista_info['cognome'],
        'data_nascita' => $logopedista_info['data_nascita'],
        'altre_info' => $logopedista_info['altre_info'],
      ]);
    }

    public function saveData() {
      $modified_data = $this->getAttributes([
        'nome', 'cognome', 'data_nascita', 'altre_info'
      ]);
      return $this->_logopedista->saveModification($modified_data);
    }

}
