<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ActionRulesHandler;
use app\models\AssignExerciseForm;
use app\models\questionariform_hierarchy\QuestionarioFormLog;
use app\models\AssignQuestionnaireForm;
use app\models\TherapyForm;
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
     * Shows all the questionnaries (first the saved ones)
     */
    public function actionQuestionnaries() {
      $_logopedista = $this->getEntityInstance();
      $questionari = $_logopedista->get_questionari()->getAllQuestionari();
      return $this->render('questionnaries', [
        'questionari' => $questionari
      ]);
    }
    /**
     * Save or unsave questionario to preferiti
     */
    public function actionSavePreferito() {
      $_logopedista = $this->getEntityInstance();
      $array_requests = Yii::$app->request->post();

      if (array_key_exists('preferito', $array_requests) && array_key_exists('idQuestionario', $array_requests)) {
        $idQuestionario = $array_requests['idQuestionario'];
        $preferito = $array_requests['preferito'];
        $_logopedista->get_questionari()->saveToPreferiti($idQuestionario, $preferito);
      }

      return $this->redirect(['logopedista/questionnaries']);
    }

    /**
     * Form to create a new questionnaire
     */
    public function actionQuestionnaireForm() {
      $array_requests = Yii::$app->request->post();
      if (array_key_exists('num_quesiti', $array_requests)) {
        $num_quesiti = $array_requests['num_quesiti'];
        return $this->render('questionnaire-form', [
          'num_quesiti' => $num_quesiti
        ]);
      }
      return $this->redirect(['logopedista/questionnaries']);
    }
    /**
     * Create the questionnaire (with quesiti)
     */
    public function actionCreateQuestionnaire() {
      $array_requests = Yii::$app->request->post();

      if (array_key_exists('titolo', $array_requests) 
       && array_key_exists('altre_info', $array_requests)) {

        $titolo = $array_requests['titolo'];
        $altre_info = $array_requests['altre_info'];

        if (array_key_exists('num_quesiti', $array_requests)) {
          $num_quesiti = $array_requests['num_quesiti'];
          $array_quesiti = [];
          for ($i=0; $i<$num_quesiti; $i++) {
            $idQuesito = 'quesito'.($i+1);
            $contenuto = $array_requests[$idQuesito];
            array_push($array_quesiti, $contenuto);
          }

          $_logopedista = $this->getEntityInstance();
          $_questionario = new QuestionarioFormLog($_logopedista, $titolo, $altre_info, $array_quesiti);
          $_questionario->saveQuestionario();
        }
      }
      return $this->redirect(['logopedista/questionnaries']);
    }

    /**
     * Show the detail of a specific questionario
     */
    public function actionShowQuestionnaire(int $idQuestionario=null) {
      if ($idQuestionario == null) {
        return $this->redirect(['logopedista/questionnaire']);
      }
      $_logopedista = $this->getEntityInstance();
      $questionario_info = $_logopedista->get_questionari()->getQuestionarioById($idQuestionario);
      return $this->render('show-questionnaire', [
        'questionario_info' => $questionario_info
      ]);
    }
    /**
     * Show the details of a specific questionario assegnato
     */
    public function actionShowAssignedQuestionnaire() {
      $array_requests = Yii::$app->request->post();

      if (array_key_exists('idTerapia', $array_requests) 
        && array_key_exists('idQuestionarioAssegnato', $array_requests)) {
        
        $idTerapia = $array_requests['idTerapia'];
        $idQuestionarioAssegnato = $array_requests['idQuestionarioAssegnato'];
        $_logopedista = $this->getEntityInstance();
        $questionario_info = $_logopedista->get_questionari()->getQuestionarioAssegnatoById($idQuestionarioAssegnato);

        return $this->render('show-assigned-questionnaire', [
          'idTerapia' => $idTerapia,
          'questionario_info' => $questionario_info
        ]);
      }
    }

    /**
     * Shows the list of all the therapies
     */
    public function actionTherapy() {
      $_logopedista = $this->getEntityInstance();
      $terapie = $_logopedista->get_terapie()->getAllTerapie();
      return $this->render('therapy', [
        'terapie' => $terapie
      ]);
    }
    /**
     * Form to start a therapy
     */
    public function actionStartTherapy() {
      $_logopedista = $this->getEntityInstance();
      $model = new TherapyForm($_logopedista);

      $utenti_result = $_logopedista->get_logopedistisalvati()->getAllCaregiverUtenti();

      if ($model->load(Yii::$app->request->post())) {
        $model->startTherapy();
        return $this->redirect(['logopedista/therapy']);
      }

      return $this->render('start-therapy', [
        'model' => $model,
        'utenti_result' => $utenti_result
      ]);
    }
    /**
     * Details of a specific therapy
     */
    public function actionTherapyDetails(int $idTerapia=null) {
      if ($idTerapia==null) {
        return $this->redirect(['logopedista/therapy']);
      }

      $_logopedista = $this->getEntityInstance();

      $terapia_info = $_logopedista->get_terapie()->getTerapiaInfoById($idTerapia);
      $caregiver_info = $_logopedista->get_terapie()->getCaregiverInfoByTerapia($idTerapia);
      $utente_info = $_logopedista->get_terapie()->getUtenteInfoByTerapia($idTerapia);
      $questionari_info = $_logopedista->get_terapie()->getQuestionariInfoByTerapia($idTerapia);
      $esercizi_info = $_logopedista->get_terapie()->getEserciziInfoByTerapia($idTerapia);

      return $this->render('therapy-details', [
        'terapia_info' => $terapia_info,
        'caregiver_info' => $caregiver_info,
        'utente_info' => $utente_info,
        'questionari_info' => $questionari_info,
        'esercizi_info' => $esercizi_info
      ]);
    }
    /**
     * End a therapy
     */
    public function actionEndTherapy(int $idTerapia=null) {
      if ($idTerapia==null) {
        return $this->redirect(['logopedista/therapy']);
      }
      $_logopedista = $this->getEntityInstance();
      $_logopedista->get_terapie()->terminateTerapia($idTerapia);
      return $this->redirect(['logopedista/therapy']);
    }
    /**
     * End a therapy
     */
    public function actionNotifyTherapy(int $idTerapia=null, int $notifiche=null) {
      if ($idTerapia==null || $notifiche===null) {
        return $this->redirect(['logopedista/therapy']);
      }
      $_logopedista = $this->getEntityInstance();
      $_logopedista->get_terapie()->changeNotificationState($idTerapia, $notifiche);
      return $this->redirect(['logopedista/therapy']);
    }


    /**
     * Assign questionnaire to a therapy
     */
    public function actionAssignQuestionnaire() {
      $_logopedista = $this->getEntityInstance();
      $model = new AssignQuestionnaireForm($_logopedista);

      $terapie_result = $_logopedista->get_terapie()->getAllTerapie();
      $questionari_result = $_logopedista->get_questionari()->getAllQuestionari();

      if ($model->load(Yii::$app->request->post())) {
        $model->assignQuestionnaire();
        return $this->redirect(['logopedista/questionnaries']);
      }

      return $this->render('assign-questionnaire', [
        'model' => $model,
        'terapie_result' => $terapie_result,
        'questionari_result' => $questionari_result
      ]);
    }
    /**
     * Assign exercise to a therapy
     */
    public function actionAssignExercise($idTerapia=null) {
      if ($idTerapia==null) {
        return $this->redirect(['logopedista/therapy']);
      }

      $_logopedista = $this->getEntityInstance();
      $model = new AssignExerciseForm($_logopedista, $idTerapia);

      if ($model->load(Yii::$app->request->post())) {
        $model->assignExercise();
        return $this->redirect(['logopedista/therapy-details?idTerapia='.$model->idTerapia]);
      }

      return $this->render('assign-exercise', [
        'model' => $model
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
