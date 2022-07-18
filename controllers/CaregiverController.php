<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ActionRulesHandler;

use app\models\UtenteForm;
use app\models\ContactForm;
use app\models\AppointmentForm;
use app\models\questionariform_hierarchy\QuestionarioFormCar;

use Exception;

use app\models\entities\Logopedista;

class CaregiverController extends Controller
{
    public $defaultAction = 'logopedisti';
    private $controllerRole = 'CAR';


    /**
     * Shows the list of all utenti with some informations
     */
    public function actionUtenti() {
      $_caregiver = $this->getEntityInstance();
      $all_utenti = $_caregiver->get_utenti()->getAllUtentiOfCaregiver();
      return $this->render('utenti', [
        'all_utenti' => $all_utenti
      ]);
    }

    /**
     * Shows the form to add/modify the info of utente
     */
    public function actionUtenteForm($type='new') {
      $_caregiver = $this->getEntityInstance();
      
      $model = new UtenteForm($_caregiver);
      if ($type=='modify') {
        $array_requests = Yii::$app->request->post();
        if (array_key_exists('idUtente', $array_requests)) {
          $idUtente = $array_requests['idUtente'];
          $model->setDefaultDataInModel($idUtente);
          return $this->render('utente-form', [
            'type' => $type,
            'idUtente' => $idUtente,
            'model' => $model
          ]);
        }
      }
      else if ($type!='new') {
        return $this->redirect(['caregiver/utente-form']);
      }

      return $this->render('utente-form', [
        'type' => $type,
        'model' => $model
      ]);
    }
    /**
     * Save the utente with the new/modified data
     */
    public function actionSaveNewUtente() {
      $_caregiver = $this->getEntityInstance();
      $model = new UtenteForm($_caregiver);

      $request_data = Yii::$app->request->post();
      if ($model->load($request_data)) {
        if ($model->saveNewData()) {
          $success_message = 'Utente aggiunto con successo';
          Yii::$app->session->setFlash('success', $success_message);
          return $this->redirect(['caregiver/utenti']);
        }
        else {
          $error_message = 'Qualcosa è andato storto nell\'aggiunta dell\'utente. Riprova';
          Yii::$app->session->setFlash('error', $error_message);
          return $this->redirect(['caregiver/utente-form?type=new']);
        }
      }

      return $this->redirect(['caregiver/utenti']);
    }
    public function actionSaveModifyUtente($idUtente) {
      $_caregiver = $this->getEntityInstance();
      $model = new UtenteForm($_caregiver);

      $request_data = Yii::$app->request->post();
      $model->setDefaultDataInModel($idUtente);
      
      if (!$model->differencesBetweenData($request_data['UtenteForm'])) {
        return $this->redirect(['caregiver/utenti']);
      }

      if ($model->load($request_data)) {
        if ($model->saveModifyData($idUtente)) {
          $success_message = 'Utente modificato con successo';
          Yii::$app->session->setFlash('success', $success_message);
        }
        else {
          $error_message = 'Qualcosa è andato storto nella modifica dei dati. Riprova';
          Yii::$app->session->setFlash('error', $error_message);
        }
      }
      return $this->redirect(['caregiver/utenti']);
    }



    /**
     * Show all saved logopedisti
     */
    public function actionLogopedisti() {
      $_caregiver = $this->getEntityInstance();
      $logopedisti_salvati = $_caregiver->get_logopedistisalvati()->getAllLogopedistiSalvati();
      return $this->render('logopedisti-salvati', [
        'logopedisti_salvati' => $logopedisti_salvati
      ]);
    }

    /**
     * Search logopedisti
     */
    public function actionSearchLogopedisti() {
      $logopedisti_trovati = null;
      $searchkey = '';

      $array_requests = Yii::$app->request->post();
      $array_requests['search'] = $searchkey;
      if (array_key_exists('search', $array_requests)) {
        $searchkey = $array_requests['search'];
        $logopedisti_trovati = Logopedista::findAllLogopedisti($searchkey);
        return $this->render('search-logopedisti', [
          'logopedisti_trovati' => $logopedisti_trovati,
          'searchkey' => $searchkey
        ]);
      }
    }

    /**
     * Save/unsave the logopedista for the caregiver
     */
    public function actionSaveLogopedista() {
      $_caregiver = $this->getEntityInstance();
      $array_requests = Yii::$app->request->post();
      if (array_key_exists('idLogopedista', $array_requests) && array_key_exists('saved', $array_requests)) {
        $idLogopedista = $array_requests['idLogopedista'];
        $saved = $array_requests['saved'];

        $save_success = $saved==1 ? 
          $_caregiver->get_logopedistisalvati()->removeLogopedistaSalvato($idLogopedista) :
          $_caregiver->get_logopedistisalvati()->addLogopedistaSalvato($idLogopedista);

        if (!$save_success) {
          $error_message = 'Qualcosa è andato storto. Riprova';
          Yii::$app->session->setFlash('error', $error_message);
        }
      }
      return $this->redirect(['caregiver/logopedisti']);
    }


    /**
     * Show the contacts and the form to start contacts
     */
    public function actionContact() {
      $_caregiver = $this->getEntityInstance();
      $model = new ContactForm($_caregiver);
      if ($model->load(Yii::$app->request->post())) {
        if ($model->sendMessaggio()) {
          return $this->redirect(['caregiver/contact']);
        }
      }

      $messaggi_risposte = $_caregiver->get_chat()->getAllMessaggiRisposte();
      $logopedisti_salvati = $_caregiver->get_logopedistisalvati()->getAllLogopedistiSalvati();
      return $this->render('contact', [
        'logopedisti_salvati' => $logopedisti_salvati,
        'messaggi_risposte' => $messaggi_risposte,
        'model' => $model
      ]);
    }


    /**
     * Shows all the appointments
     */
    public function actionAppointment() {
      $_caregiver = $this->getEntityInstance();
      $appuntamenti = $_caregiver->get_appuntamenti()->getAllAppuntamenti();
      return $this->render('appointment', [
        'appuntamenti' => $appuntamenti
      ]);
    }
    /**
     * Form to book an appointment
     */
    public function actionAppointmentForm() {
      $_caregiver = $this->getEntityInstance();

      $model = new AppointmentForm($_caregiver);

      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ($model->saveAppointment()) {
          return $this->redirect(['caregiver/appointment']);
        }
      }

      $logopedisti_salvati = $_caregiver->get_logopedistisalvati()->getAllLogopedistiSalvati();
      return $this->render('appointment-form', [
        'model' => $model,
        'logopedisti_salvati' => $logopedisti_salvati
      ]);
    }
    /**
     * Cancel the booking to an appointment
     */
    public function actionAppointmentCancel() {
      $_caregiver = $this->getEntityInstance();

      $array_requests = Yii::$app->request->post();
      if (array_key_exists('idAppuntamento', $array_requests)) {
        $idAppuntamento = $array_requests['idAppuntamento'];
        $_caregiver->get_appuntamenti()->cancelAppointment($idAppuntamento);
      }
      return $this->redirect(['caregiver/appointment']);
    }


    /**
     * Shows all the therapies
     */
    public function actionTherapy() {
      $_caregiver = $this->getEntityInstance();
      $terapie = $_caregiver->get_terapie()->getAllTerapie();
      return $this->render('therapy', [
        'terapie' => $terapie
      ]);
    }
    /**
     * Details of a single therapy
     */
    public function actionTherapyDetails(int $idTerapia=null) {
      if ($idTerapia==null) {
        return $this->redirect(['caregiver/therapy']);
      }

      $_caregiver = $this->getEntityInstance();

      $terapia_info = $_caregiver->get_terapie()->getTerapiaInfoById($idTerapia);
      $logopedista_info = $_caregiver->get_terapie()->getLogopedistaInfoByTerapia($idTerapia);
      $utente_info = $_caregiver->get_terapie()->getUtenteInfoByTerapia($idTerapia);
      $questionari_info = $_caregiver->get_terapie()->getQuestionariInfoByTerapia($idTerapia);
      $esercizi_info = $_caregiver->get_terapie()->getEserciziInfoByTerapia($idTerapia);

      return $this->render('therapy-details', [
        'terapia_info' => $terapia_info,
        'logopedista_info' => $logopedista_info,
        'utente_info' => $utente_info,
        'questionari_info' => $questionari_info,
        'esercizi_info' => $esercizi_info
      ]);
    }

    /**
     * Shows the questionnaire with the fields to compile it
     */
    public function actionShowQuestionnaire() {
      $array_requests = Yii::$app->request->post();

      if (array_key_exists('idQuestionarioAssegnato', $array_requests)
        && array_key_exists('idTerapia', $array_requests)) {
        $idQuestionarioAssegnato = $array_requests['idQuestionarioAssegnato'];
        $idTerapia = $array_requests['idTerapia'];

        $_caregiver = $this->getEntityInstance();
        $questionarioassegnato = $_caregiver->get_questionari()->getQuestionarioAssegnatoInfo($idQuestionarioAssegnato);
        $idQuestionario = $questionarioassegnato['id'];
        $questionario_info = $_caregiver->get_questionari()->getQuestionarioById($idQuestionario);
        
        return $this->render('show-questionnaire', [
          'questionario_info' => $questionario_info,
          'idQuestionarioAssegnato' => $idQuestionarioAssegnato,
          'idTerapia' => $idTerapia
        ]);
      }

      return $this->redirect(['caregiver/therapy']);
    }
    /**
     * Answer to the questionnaire
     */
    public function actionAnswerQuestionnaire() {
      $array_requests = Yii::$app->request->post();

      if (array_key_exists('idQuestionarioAssegnato', $array_requests) 
       && array_key_exists('num_quesiti', $array_requests)) {

        $idQuestionarioAssegnato = $array_requests['idQuestionarioAssegnato'];
        unset($array_requests['idQuestionarioAssegnato']);
        $num_quesiti = $array_requests['num_quesiti'];
        unset($array_requests['num_quesiti']);

        $array_quesiti = [];
        foreach ($array_requests as $key => $value) {
          if ($key=='_csrf') {
            continue;
          }
          $risposta = [
            'id' => $key,
            'contenuto' => $value
          ];
          array_push($array_quesiti, $risposta);
        }

        $_caregiver = $this->getEntityInstance();
        $_questionario = new QuestionarioFormCar($_caregiver, $idQuestionarioAssegnato, $array_quesiti);
        $_questionario->saveQuestionario();
      }
      return $this->redirect(['caregiver/therapy']);
    }

    /**
     * 
     */
    public function actionEndExercise($idEsercizio=null) {
      if ($idEsercizio==null) {
        return $this->redirect(['logopedista/therapy']);
      }

      $_caregiver = $this->getEntityInstance();
      $_caregiver->get_esercizi()->endExercise($idEsercizio);

      $terapia_info = $_caregiver->get_esercizi()->getTerapiaInfoByEsercizio($idEsercizio);
      if ($terapia_info['notifiche']==1) {
        $email_logopedista = $terapia_info['email'];
        //invio notifica
      }
      return $this->redirect(['caregiver/therapy-details?idTerapia='.$terapia_info['ter_id']]);
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
