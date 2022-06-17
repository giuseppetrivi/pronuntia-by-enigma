<?php

namespace app\models\entities;

use Yii;
use yii\db\ActiveRecord;
use PDO;

class Caregiver extends ActiveRecord {

  private static $tableName = 'caregiver';

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
   * 
   */
  public function getCaregiverInfo() {
    $id = $this->__get('id');
    $sql = "SELECT * FROM caregiver WHERE id=:idCar LIMIT 1";
    $caregiver_info = Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $id)
      ->queryOne();
    return $caregiver_info;
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



}

?>