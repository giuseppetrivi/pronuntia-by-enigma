<?php

namespace app\models\modifyaccount_hierarchy;

use Yii;
use yii\base\Model;
use Exception;


/**
 * 
 */
abstract class ModifyAccountBase extends Model {

  protected $_roleInstance = null;


  public function __construct($_roleInstance) {
    $this->_roleInstance = $_roleInstance;
    $this->setDefaultDataInModel();
  }


  /*
   * Set custom labels for the attributes
   * @return array the attribute labels
   *
  abstract public function attributeLabels();

  **
   * @return array the validation rules.
   *
  abstract public function rules();*/


  /**
   * Fill the attributes with the data of the account
   */
  abstract protected function setDefaultDataInModel();

  /**
   * Scan the attributes of model and the request_data array to
   * find differences
   * @return int
   */
  public function differencesBetweenData($request_data) {
    $model_attributes = $this->getAttributes();
    return count(array_diff_assoc($model_attributes, $request_data))==0 ? false : true;
  }


  /**
   * Save the data in the database
   * @return int
   */
  abstract public function saveData();

}
