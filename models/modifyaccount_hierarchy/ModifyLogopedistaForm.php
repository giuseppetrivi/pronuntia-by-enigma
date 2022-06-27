<?php

namespace app\models\modifyaccount_hierarchy;

use Yii;
use Exception;


/**
 * 
 */
class ModifyLogopedistaForm extends ModifyAccountBase {

  public $nome;
  public $cognome;
  public $data_nascita;
  public $altre_info;


  public function __construct($_logopedista) {
    parent::__construct($_logopedista);
  }


  public function attributeLabels() {
    return [
      'nome' => 'Nome',
      'cognome' => 'Cognome',
      'data_nascita' => 'Data di nascita',
      'altre_info' => 'Altre informazioni'
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
        ['altre_info'], 
        'string', 
        'max' => 255,
        'tooLong' => '{attribute} è troppo lungo'
      ],
    ];
  }


  protected function setDefaultDataInModel() {
    $logopedista_info = $this->_roleInstance->getRoleAccountInfo();

    if (count($logopedista_info)===0) {
      throw new Exception();
    }

    $this->setAttributes([
      'nome' => $logopedista_info['nome'],
      'cognome' => $logopedista_info['cognome'],
      'data_nascita' => $logopedista_info['data_nascita'],
      'altre_info' => $logopedista_info['bio'],
    ]);
  }

  
  public function saveData() {
    $modified_data = $this->getAttributes([
      'nome', 'cognome', 'data_nascita', 'altre_info'
    ]);
    $modified_data['altre_info'] = $modified_data['altre_info']=='' ? null : $modified_data['altre_info'];
    return $this->_roleInstance->saveModification($modified_data);
  }

}
