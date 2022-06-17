<?php

namespace app\models\modifyaccountform;


interface ModifyAccountInterface {

  /**
   * 
   */
  //public function setDefaultDataInModel();

  /**
   * 
   */
  public function differencesBetweenData($request_data);

  /**
   * 
   */
  public function saveData();

}

?>