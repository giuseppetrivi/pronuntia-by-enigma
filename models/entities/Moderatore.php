<?php

namespace app\models\entities;

use Yii;
use yii\db\ActiveRecord;

class Moderatore extends ActiveRecord {

  private static $tableName = 'moderatori';

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
   * Get some info about logopedisti to confirm registration
   * 
   * @return array
   */
  public function getLogopedistiToConfirm() {
    $query = "SELECT id, nome, cognome, data_registrazione FROM logopedisti "
      . "WHERE confermato IS NULL ORDER BY data_registrazione ASC";
    
    $logopedistiToConfirm = Yii::$app->db->createCommand($query)
      ->queryAll();
    
    return $logopedistiToConfirm;
  }


  /**
   * Get all info about a logopedista by his id
   * 
   * @return array
   */
  public function getLogopedistaInfoById($id) {
    $query = "SELECT * FROM logopedisti "
      . "WHERE id=:idLog LIMIT 1";
    
    $logopedistaInfo = Yii::$app->db->createCommand($query)
      ->bindParam(':idLog', $id)
      ->queryOne();
    
    return $logopedistaInfo;
  }



}

?>