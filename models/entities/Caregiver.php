<?php

namespace app\models\entities;

use Yii;
use yii\db\ActiveRecord;

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




}

?>