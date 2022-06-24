<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ActionRulesHandler;

use app\models\modifyaccountform\ModifyCaregiverForm;
use app\models\UtenteForm;
use app\models\ContactForm;

use app\models\role_factory_method\RoleCreator;
use Exception;

use app\models\entities\Logopedista;
use app\models\entities\LogopedistiSalvati;

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
      $logopedisti_salvati = LogopedistiSalvati::getAllLogopedistiSalvatiByCaregiver($_caregiver->__get('id'));
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
      if (array_key_exists('search', $array_requests)) {
        $searchkey = $array_requests['search'];
        $logopedisti_trovati = Logopedista::findAllLogopedisti($searchkey);
      }
      return $this->render('search-logopedisti', [
        'logopedisti_trovati' => $logopedisti_trovati,
        'searchkey' => $searchkey
      ]);
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
      $logopedisti_salvati = LogopedistiSalvati::getAllLogopedistiSalvatiByCaregiver($_caregiver->__get('id'));
      return $this->render('contact', [
        'logopedisti_salvati' => $logopedisti_salvati,
        'messaggi_risposte' => $messaggi_risposte,
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
