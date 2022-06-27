<?php

namespace app\models\modifyaccount_hierarchy;

use Yii;
use yii\base\Model;
use app\models\role_factory_method\RoleCreator;
use Exception;


/**
 * 
 */
class ModifyCaregiverForm extends ModifyAccountBase {

  public $nome;
  public $cognome;
  public $data_nascita;
  public $num_telefono;


  public function __construct($_caregiver) {
    parent::__construct($_caregiver);
  }


  public function attributeLabels() {
    return [
      'nome' => 'Nome',
      'cognome' => 'Cognome',
      'data_nascita' => 'Data di nascita',
      'num_telefono' => 'Numero di telefono'
    ];
  }

  public function rules() {
    return [
      [
        ['nome', 'cognome', 'data_nascita'], 
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
        'num_telefono', 
        'integer',
        'message' => '{attribute} non è valido'
      ],
    ];
  }


  protected function setDefaultDataInModel() {
    $caregiver_info = $this->_roleInstance->getRoleAccountInfo();

    if (count($caregiver_info)===0) {
      throw new Exception();
    }

    $this->nome = $caregiver_info['nome'];
    $this->cognome = $caregiver_info['cognome'];
    $this->data_nascita = $caregiver_info['data_nascita'];
    $this->num_telefono = $caregiver_info['num_telefono'];
  }


  public function saveData() {
    $modified_data = $this->getAttributes([
      'nome', 'cognome', 'data_nascita', 'num_telefono'
    ]);
    return $this->_roleInstance->saveModification($modified_data);
  }

}
