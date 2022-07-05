<?php

namespace app\models\role_factory_method;

use Exception;


abstract class RoleCreator {

  private static $instance = null;

  protected function __construct() {}

  /**
   * Choose and return the right instance based on role of user
   * 
   * @return RoleProductInterface
   */
  public static function getInstance($type) {
    if (self::$instance == null) {
      switch ($type) {
        case 'LOG':
          self::$instance = new RoleLogopedista();
          break;
        case 'CAR':
          self::$instance = new RoleCaregiver();
          break;
        case 'MOD':
          self::$instance = new RoleModeratore();
          break;

        default:
          //throw new Exception("Errore nell'etichetta del linguaggio");
          return false;
          break;
      }
    }
    return self::$instance;
    //throw new Exception('Errore nei dati passati');
  }


}


?>