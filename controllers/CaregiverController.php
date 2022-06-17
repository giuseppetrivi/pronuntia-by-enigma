<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ActionRulesHandler;
use app\models\modifyaccountform\ModifyCaregiverForm;
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

      return $this->render('account');
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
