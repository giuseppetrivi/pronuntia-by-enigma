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

  public function getNome() {
    return $this->nome;
  }






}

?>