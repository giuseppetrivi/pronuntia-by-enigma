<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\role_factory_method\RoleCreator;

class SiteController extends Controller
{
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

    /**
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {

        $type = !Yii::$app->user->isGuest ? Yii::$app->user->identity->tipo : null;
        $homePage = 'site/index';

        $_roleHandler = RoleCreator::getInstance($type);
        if ($_roleHandler) {
            $homePage = $_roleHandler->getRoleHomePage();
        }

        if (!Yii::$app->user->isGuest) {
            return $this->redirect([$homePage]);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect([$homePage]);
        }

        $model->password = ''; //security
        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(['site/index']);
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }


    /**
     * Register form.
     *
     * @return string
     */
    public function actionRegister() {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->register()) {
                $success_message = 'Registrazione avvenuta con successo. Effettua il login per entrare';
                Yii::$app->session->setFlash('success', $success_message);
                return $this->redirect(['site/login']);
            }
            else {
                $error_message = 'Qualcosa è andato storto nella registrazione. Riprova';
                Yii::$app->session->setFlash('error', $error_message);
                return $this->redirect(['site/register']);
            }
        }

        return $this->render('register', ['model' => $model]);
    }

}
