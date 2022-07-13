<?php

namespace app\models\entities;

use app\models\modifyaccount_hierarchy\ModifyEntitiesInterface;
use Yii;
use yii\db\ActiveRecord;
use PDO;

class Caregiver extends ActiveRecord implements ModifyEntitiesInterface {

  private static $tableName = 'caregiver';

  private $_utenti = null;
  private $_chat = null;
  private $_logopedistisalvati = null;
  private $_appuntamenti = null;
  private $_questionari = null;
  private $_terapie = null;
  private $_esercizi = null;

  public static function tableName() {
    return '{{'.self::$tableName.'}}';
  }

  /**
   * {@inheritdoc}
   */
  public static function findIdentity($id) {
    return static::findOne(['account_email' => $id]);
  }


  /**
   * Get all caregiver informations stored in database
   */
  public function getRoleAccountInfo() {
    $id = $this->__get('id');
    $sql = "SELECT * FROM caregiver WHERE id=:idCar LIMIT 1";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryOne();
  }

  /**
   * Save the modified data in the database
   */
  public function saveModification($modified_data) {
    $id = $this->__get('id');
    $sql = "UPDATE caregiver 
      SET nome=:nome , cognome=:cognome , data_nascita=:dataNascita , num_telefono=:numTel
      WHERE id=:idCar";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':nome', $modified_data['nome'])
      ->bindParam(':cognome', $modified_data['cognome'])
      ->bindParam(':dataNascita', $modified_data['data_nascita'])
      ->bindParam(':numTel', $modified_data['num_telefono'], PDO::PARAM_STR)
      ->bindParam(':idCar', $id)
      ->execute();
  }
  

  /**
   * Return (and create) an instance of class Utenti to handle utenti
   */
  public function get_utenti() {
    if ($this->_utenti==null) {
      $this->_utenti = new Utenti($this->__get('id'));
    }
    return $this->_utenti;
  }

  /**
   * Return (and create) an instance of class LogopedistiSalvati
   * to handle the logopedisti salvati
   */
  public function get_logopedistisalvati() {
    if ($this->_logopedistisalvati==null) {
      $this->_logopedistisalvati = new LogopedistiSalvatiCar($this->__get('id'));
    }
    return $this->_logopedistisalvati;
  }

  /**
   * Return (and create) an instance of class Chat to handle utenti
   */
  public function get_chat() {
    if ($this->_chat==null) {
      $this->_chat = new ChatCar($this->__get('id'));
    }
    return $this->_chat;
  }

  /**
   * Return (and create) an instance of class AppuntamentiCar to handle utenti
   */
  public function get_appuntamenti() {
    if ($this->_appuntamenti==null) {
      $this->_appuntamenti = new AppuntamentiCar($this->__get('id'));
    }
    return $this->_appuntamenti;
  }

  /**
   * Return (and create) an instance of class QuestionariCar to handle questionari
   */
  public function get_questionari() {
    if ($this->_questionari==null) {
      $this->_questionari = new QuestionariCar($this->__get('id'));
    }
    return $this->_questionari;
  }

  /**
   * Return (and create) an instance of class TerapieCar to handle terapie
   */
  public function get_terapie() {
    if ($this->_terapie==null) {
      $this->_terapie = new TerapieCar($this->__get('id'));
    }
    return $this->_terapie;
  }

  /**
   * Return (and create) an instance of class EserciziCar to handle esercizi
   */
  public function get_esercizi() {
    if ($this->_esercizi==null) {
      $this->_esercizi = new EserciziCar($this->__get('id'));
    }
    return $this->_esercizi;
  }


}

?>