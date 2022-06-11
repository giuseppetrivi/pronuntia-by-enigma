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
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**SI POTREBBE ANCHE TOGLIERE
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

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
     * Displays logopedista infos.
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

        //ricerca e restituzione logopedista by id
        //informazioni anche sui reject subiti
        return $this->render('logopedista-info', [
            'model' => new InfoLogopedistaToCheckForm(),
            'logopedista_info' => $logopedista_info
        ]); //con parametro
    }


    /**
     * 
     */
    public function actionAcceptLogopedista($id) {

    }
    /**
     * 
     */
    public function actionRejectLogopedista($id) {

    }
    /**
     * 
     */
    public function actionDenyLogopedista($id) {

    }



    /**
     * Displays logopedista infos.
     *
     * @return string
     */
    public function actionAccount() {
        //restituisce una pagina con tutte le info del moderatore
        $_moderatore = $this->getEntityInstance();
        return $this->render('account', ['_moderatore' => $_moderatore]);
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
