<?php

namespace app\models\entities;

use app\models\modifyaccount_hierarchy\ModifyEntitiesInterface;
use Yii;
use yii\db\ActiveRecord;

class Logopedista extends ActiveRecord implements ModifyEntitiesInterface {

  private static $tableName = 'logopedisti';

  private $_chat = null;
  private $_logopedistisalvati = null;
  private $_appuntamenti = null;

  public static function tableName() {
    return '{{'.self::$tableName.'}}';
  }


  /**
   * {@inheritdoc}
   */
  public static function findIdentity($email) {
    return static::findOne(['account_email' => $email]);
  }

  /**
   * {@inheritdoc}
   */
  public static function findById($id) {
    return static::findOne(['id' => $id]);
  }
  

  /**
   * Find all logopedisti by searchkey
   */
  public static function findAllLogopedisti($searchkey) {
    $sql = "SELECT id, nome, cognome, account_email, bio , caregiver_id AS salvato
      FROM logopedisti LEFT JOIN logopedistisalvati ON id=logopedista_id
      WHERE cognome LIKE :cognome OR nome LIKE :nome
      ORDER BY nome ASC";
    $cognome = '%'.$searchkey.'%';
    $nome = '%'.$searchkey.'%';
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':cognome', $cognome)
      ->bindParam(':nome', $nome)
      ->queryAll();
  }


  /**
   * Get all logopedista informations stored in database
   */
  public function getRoleAccountInfo() {
    $id = $this->__get('id');
    $sql = "SELECT * FROM logopedisti WHERE id=:idLog LIMIT 1";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $id)
      ->queryOne();
  }

  /**
   * Save the modified data in the database
   */
  public function saveModification($modified_data) {
    $id = $this->__get('id');
    $sql = "UPDATE logopedisti 
      SET nome=:nome , cognome=:cognome , data_nascita=:dataNascita , bio=:bio
      WHERE id=:idLog";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':nome', $modified_data['nome'])
      ->bindParam(':cognome', $modified_data['cognome'])
      ->bindParam(':dataNascita', $modified_data['data_nascita'])
      ->bindParam(':bio', $modified_data['altre_info'])
      ->bindParam(':idLog', $id)
      ->execute();
  }


  /**
   * Return (and create) an instance of class LogopedistiSalvati
   * to handle the logopedisti salvati
   */
  public function get_logopedistisalvati() {
    if ($this->_logopedistisalvati==null) {
      $this->_logopedistisalvati = new LogopedistiSalvati($this->__get('id'));
    }
    return $this->_logopedistisalvati;
  }

  /**
   * Return (and create) an instance of class Chat to handle utenti
   */
  public function get_chat() {
    if ($this->_chat==null) {
      $this->_chat = new ChatLog($this->__get('id'));
    }
    return $this->_chat;
  }

  /**
   * Return (and create) an instance of class AppuntamentiCar to handle utenti
   */
  public function get_appuntamenti() {
    if ($this->_appuntamenti==null) {
      $this->_appuntamenti = new AppuntamentiLog($this->__get('id'));
    }
    return $this->_appuntamenti;
  }




}

?>