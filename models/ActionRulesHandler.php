<?php

namespace app\models;

use Yii;
use app\models\role_factory_method\RoleCreator;


/**
 * Class to check the controller rule, if has the permission for 
 * the controller class actions
 */
class ActionRulesHandler {

  public static function checkControllerRule($controllerRole) {
    $userRole = !Yii::$app->user->isGuest ? Yii::$app->user->identity->tipo : null;

    $homePage = 'site/index';

    if ($controllerRole=='*') {
      return true;
    }
    else if ($userRole!=null) {
      if ($controllerRole==$userRole) {
        return true;
      }

      $_roleHandler = RoleCreator::getInstance($userRole);
      if ($_roleHandler) {
        $homePage = $_roleHandler->getRoleHomePage();
      }
    }

    return $homePage;
  }

}

?>