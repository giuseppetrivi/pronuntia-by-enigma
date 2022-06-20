<?php

namespace app\models\entities;

use Yii;
use yii\db\ActiveRecord;

class Logopedista extends ActiveRecord {

  private static $tableName = 'logopedisti';

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
   * 
   */
  public static function getAllLogopedistiSalvati($idCaregiver) {
    $sql = "SELECT id, nome, cognome, account_email, bio , caregiver_id AS salvato
      FROM logopedistisalvati, logopedisti 
      WHERE caregiver_id=:idCar AND id=logopedista_id";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idCar', $idCaregiver)
      ->queryAll();
  }




}

?>