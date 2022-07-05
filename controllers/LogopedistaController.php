<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ActionRulesHandler;

use Exception;


class LogopedistaController extends Controller
{
    public $defaultAction = 'logopedisti';
    private $controllerRole = 'LOG';
    


    /**
     * Show the contacts and the form to start contacts
     */
    public function actionMessages() {
      $_logopedista = $this->getEntityInstance();
      $messaggi_risposte = $_logopedista->get_chat()->getAllMessaggiRisposte();
      return $this->render('messages', [
        'messaggi_risposte' => $messaggi_risposte
      ]);
    }
    /**
     * Show the contacts and the form to start contacts
     */
    public function actionMessagesRispondi() {
      $_logopedista = $this->getEntityInstance();

      $array_requests = Yii::$app->request->post();
      if (array_key_exists('idMessaggio', $array_requests) && array_key_exists('risposta', $array_requests)) {
        $idMessaggio = $array_requests['idMessaggio'];
        $risposta = $array_requests['risposta'];

        $attributes = [
          'idMessaggio' => $idMessaggio,
          'risposta' => $risposta
        ];
        $_logopedista->get_chat()->setRisposta($attributes);
      }
      
      return $this->redirect(['logopedista/messages']);
    }


    /**
     * Shows all the appointments
     */
    public function actionAppointment() {
      $today = date('Y-m-d');
      $prev_day = date('Y-m-d', strtotime($today .' -1 day'));
      $next_day = date('Y-m-d', strtotime($today .' +1 day'));
      $next2_day = date('Y-m-d', strtotime($today .' +2 day'));
      $dates = [
        'prev_day' => $prev_day,
        'today' => $today,
        'next_day' => $next_day,
        'next2_day' => $next2_day,
      ];

      $_logopedista = $this->getEntityInstance();
      $appuntamenti = $_logopedista->get_appuntamenti()->getAllAppuntamenti($dates);
      return $this->render('appointment', [
        'dates' => $dates,
        'appuntamenti' => $appuntamenti
      ]);
    }



    /**
     * Get the entity instance based on the role, after check that user exists
     * 
     * @return RoleProductInterface
     * @throws Exception
     */
    private function getEntityInstance() {
      return ActionRulesHandler::getEntityInstance();
   }



    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) {
        /* code for overriding */
        if (!parent::beforeAction($action)) {
            return false;
        }

        /* code to check the role */
        $result = ActionRulesHandler::checkControllerRule($this->controllerRole);
        $resultType = gettype($result);

        if ($resultType=='string'){
            $this->redirect([$result]);
            $result = true;
        }

        return $result;
    }

}
