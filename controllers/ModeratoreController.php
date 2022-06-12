<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ActionRulesHandler;
use app\models\InfoLogopedistaToCheckForm;
use app\models\role_factory_method\RoleCreator;
use Exception;


class ModeratoreController extends Controller
{
    public $defaultAction = 'logopedisti-list';
    private $controllerRole = 'MOD';

    /**
     * Displays logopedisti list.
     *
     * @return string
     */
    public function actionLogopedistiList() {
        $_moderatore = $this->getEntityInstance();
        $logopedisti_list = $_moderatore->getLogopedistiToConfirm();
        return $this->render('logopedisti-list', ['logopedisti_list' => $logopedisti_list]);
    }


    /**
     * Displays logopedista infos, to choose if is acceptable or not.
     *
     * @return string
     */
    public function actionLogopedistaInfo($id) {
        $_moderatore = $this->getEntityInstance();

        $logopedista_info = $_moderatore->getLogopedistaInfoById($id);
        if (!$logopedista_info) {
            $error_message = 'L\'utente selezionato non è stato trovato. Riprova';
            Yii::$app->session->setFlash('error', $error_message);
            return $this->redirect(['moderatore/logopedisti-list']);
        }
        
        $rejection_info = $_moderatore->getRejectionInfoByLogopedistaId($id);

        return $this->render('logopedista-info', [
            'model' => new InfoLogopedistaToCheckForm(),
            'logopedista_info' => $logopedista_info,
            'rejection_info' => $rejection_info
        ]);
    }


    /**
     * Confirm the registration of the logopedista
     */
    public function actionAcceptLogopedista() {
        $arrayRequests = Yii::$app->request->post();
        if (array_key_exists('id', $arrayRequests)) {
            $idLogopedista = $arrayRequests['id'];
            $_moderatore = $this->getEntityInstance();
            $_moderatore->acceptLogopedista($idLogopedista); //da controllare
            return $this->redirect(['moderatore/logopedisti-list']);            
        }
    }
    /**
     * Reject the registration of the logopedista
     */
    public function actionRejectLogopedista() {
        $arrayRequests = Yii::$app->request->post();
        if (array_key_exists('id', $arrayRequests)) {
            $idLogopedista = $arrayRequests['id'];
            if (array_key_exists('motivo', $arrayRequests)) {
                $motivo = $arrayRequests['motivo'];
                if ($motivo=='') {
                    $error_message = 'Il campo della motivazione deve essere compilato!! Riprova';
                    Yii::$app->session->setFlash('error', $error_message);
                    return $this->redirect(['moderatore/logopedista-info?id=' . $idLogopedista]);
                }
                else {
                    $_moderatore = $this->getEntityInstance();
                    $_moderatore->rejectLogopedista($idLogopedista, $motivo);
                    return $this->redirect(['moderatore/logopedisti-list']);  
                }
            }          
        }
    }
    /**
     * Refuse the registration of the logopedista
     */
    public function actionDenyLogopedista() {
        $arrayRequests = Yii::$app->request->post();
        if (array_key_exists('id', $arrayRequests)) {
            $idLogopedista = $arrayRequests['id'];
            $_moderatore = $this->getEntityInstance();
            $_moderatore->denyLogopedista($idLogopedista); //da controllare
            return $this->redirect(['moderatore/logopedisti-list']);              
        }
    }



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
