<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class ModeratoreController extends Controller
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
      return $this->render('logopedisti-list');
    }


    /**
     * Displays logopedista infos.
     *
     * @return string
     */
    public function actionLogopedistaInfo($id) {
      //ricerca e restituzione logopedista by id
      //informazioni anche sui reject subiti
      return $this->render('logopedista-info'); //con parametro
    }


    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) {

        //return false;
        $type = !Yii::$app->user->isGuest ? Yii::$app->user->identity->tipo : null;
        /*if ($type==$this->permissionType) {
            //codice
        }*/
    
        if (!parent::beforeAction($action)) {
            return false;
        }
    
        // other custom code here
    
        return true; // or false to not run the action
    }

}
