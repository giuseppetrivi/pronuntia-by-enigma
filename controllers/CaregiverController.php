<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ActionRulesHandler;

use app\models\modifyaccountform\ModifyCaregiverForm;
use app\models\UtenteForm;

use app\models\role_factory_method\RoleCreator;
use Exception;


class CaregiverController extends Controller
{
    public $defaultAction = 'account';
    private $controllerRole = 'CAR';


    /**
     * Show account informations
     */
    public function actionAccount() {
      $_caregiver = $this->getEntityInstance();
      $caregiver_info = $_caregiver->getCaregiverInfo();
      return $this->render('account', [
        'caregiver_info' => $caregiver_info
      ]);
    }

    /**
     * Show and set the form to modify the account informations
     */
    public function actionModifyAccount() {
      $_caregiver = $this->getEntityInstance();
      $model = new ModifyCaregiverForm($_caregiver);

      return $this->render('modify-account', [
        'model' => $model
      ]);
    }
    /**
     * Save the modifications on the account informations
     */
    public function actionSaveAccount() {
      $_caregiver = $this->getEntityInstance();
      $model = new ModifyCaregiverForm($_caregiver);

      $request_data = Yii::$app->request->post();

      if (!$model->differencesBetweenData($request_data['ModifyCaregiverForm'])) {
        return $this->redirect(['caregiver/account']);
      }

      if ($model->load($request_data)) {
        if ($model->saveData()) {
          $success_message = 'Modifica effettuata con successo';
          Yii::$app->session->setFlash('success', $success_message);
          return $this->redirect(['caregiver/account']);
        }
        else {
          $error_message = 'Qualcosa è andato storto nella modifica dei dati. Riprova';
          Yii::$app->session->setFlash('error', $error_message);
          return $this->redirect(['caregiver/modify-account']);
        }
      }

      return $this->redirect(['caregiver/account']);
    }


    /**
     * Shows the list of all utenti with some informations
     */
    public function actionUtenti() {
      $_caregiver = $this->getEntityInstance();
      $all_utenti = $_caregiver->getAllUtentiOfCaregiver();
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
     * 
     */



    /**
     * Get the entity instance based on the role, after check that user exists
     * 
     * @return RoleProductInterface
     * @throws Exception
     */
    private function getEntityInstance() {
        $_roleHandler = RoleCreator::getInstance(Yii::$app->user->identity->tipo);
        if (!$_roleHandler) {
            throw new Exception("Error in the role handler");
        }
        $_entityInstance = $_roleHandler->getEntityInstance(Yii::$app->user->identity->email);
        return $_entityInstance;
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
