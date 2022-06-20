<?php

namespace app\views\layouts;

use Yii;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;


/**
 * Class to dynamically change the navigation bar
 */
class NavBarOptionsHandler {

  public static function chooseNavBar() {
    $userRole = !Yii::$app->user->isGuest ? Yii::$app->user->identity->tipo : null;
    switch ($userRole) {
      case 'LOG':
        return NavBarOptionsHandler::defaultNavBar();
        break;
      case 'CAR':
        return NavBarOptionsHandler::caregiverNavBar();
        break;
      case 'MOD':
        return NavBarOptionsHandler::moderatoreNavBar();
        break;

      default:
        return NavBarOptionsHandler::defaultNavBar();
        break;
    }
  }


  private static function defaultNavBar() {
    return Nav::widget([
      'options' => ['class' => 'navbar-nav'],
      'items' => [
          ['label' => 'Home', 'url' => ['/site/index']],
          ['label' => 'About', 'url' => ['/site/about']],
          Yii::$app->user->isGuest ? (
              ['label' => 'Login', 'url' => ['/site/login']]
          ) : (
              '<li>'
              . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
              . Html::submitButton(
                  'Logout (' . Yii::$app->user->identity->email . ')',
                  ['class' => 'btn btn-link logout']
              )
              . Html::endForm()
              . '</li>'
          ),
          Yii::$app->user->isGuest ? (
              ['label' => 'Registrati', 'url' => ['/site/register']]
          ) : ('')
      ],
    ]);
  }

  private static function moderatoreNavBar() {
    return Nav::widget([
      'options' => ['class' => 'navbar-nav'],
      'items' => [
          ['label' => 'Lista logopedisti', 'url' => ['/moderatore/logopedisti-list']],
          (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->email . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
          )
      ],
    ]);
  }

  private static function caregiverNavBar() {
    return Nav::widget([
      'options' => ['class' => 'navbar-nav'],
      'items' => [
          ['label' => 'Contatta', 'url' => ['/caregiver/contact']],
          ['label' => 'Logopedisti', 'url' => ['/caregiver/logopedisti']],
          ['label' => 'Utenti', 'url' => ['/caregiver/utenti']],
          ['label' => 'Account', 'url' => ['/caregiver/account']],
          (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->email . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
          )
      ],
    ]);
  }

}


?>