<?php

namespace app\models\modifyaccount_hierarchy;


interface ModifyEntitiesInterface {

  /**
   * Get from the database all the account informations
   */
  public function getRoleAccountInfo();

  /**
   * Save the modified data in the database
   */
  public function saveModification($modified_data);

}

?>