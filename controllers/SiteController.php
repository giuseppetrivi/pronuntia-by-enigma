<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\LoginForm;

use app\controllers\ActionRulesHandler;
use ReflectionClass;

class SiteController extends Controller
{
  public $defaultAction = 'index';
  private $controllerRole = '*';


  /**
   * {@inheritdoc}
   */
  /*public function behaviors() //si potrebbe togliere
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
  }*/


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
  public function actionLogin()
  {

    $homePage = $this->getHomePage();

    if (!Yii::$app->user->isGuest) {
      return $this->redirect([$homePage]);
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      $homePage = $this->getHomePage();
      return $this->redirect([$homePage]);
    }

    $model->password = ''; //security
    return $this->render('login', [
      'model' => $model
    ]);
  }

  /**
   * Check the if the user is logged and return the right home page
   * 
   * @return string
   */
  private function getHomePage()
  {
    $type = !Yii::$app->user->isGuest ? Yii::$app->user->identity->tipo : null;
    $homePage = 'site/index';
    if ($type!=null) {
      $homePage = $this->getRoleHandler()->getRoleHomePage();
    }
    return $homePage;
  }


  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->redirect(['site/index']);
  }


  /**
   * Displays about page.
   *
   * @return string
   */
  public function actionAbout()
  {
    return $this->render('about');
  }


  /**
   * Register form.
   *
   * @return string
   */
  public function actionRegister($type = 'LOG')
  {

    $homePage = $this->getHomePage();

    if (!Yii::$app->user->isGuest) {
      return $this->redirect([$homePage]);
    }

    $model = $this->getRoleHandlerByType($type)->getRegisterModelInstance();

    if ($model == null) {
      return $this->redirect(['site/index']);
    }

    if ($model->load(Yii::$app->request->post())) {
      if ($model->register()) {
        $success_message = 'Registrazione avvenuta con successo. Effettua il login per entrare';
        Yii::$app->session->setFlash('success', $success_message);
        return $this->redirect(['site/login']);
      }
      /*else {
        $error_message = 'Qualcosa è andato storto nella registrazione. Riprova';
        Yii::$app->session->setFlash('error', $error_message);
        return $this->redirect(['site/register']);
      }*/
    }

    return $this->render('register', ['model' => $model]);
  }


  private function checkType()
  {
    if (!Yii::$app->user->isGuest) {
      $type = Yii::$app->user->identity->tipo;
      if ($type=='LOG' || $type=='CAR') {
        return $type;
      }
    }
    return $this->redirect(['site/index']);
  }
  /**
   * Show account informations
   */
  public function actionAccount() {
    $type = $this->checkType();
    $_roleInstance = $this->getEntityInstance();
    $role_info = $_roleInstance->getRoleAccountInfo();

    return $this->render('account', [
      'role_info' => $role_info,
      'type' => $type
    ]);

  }

  /**
   * Show and set the form to modify the account informations
   */
  public function actionModifyAccount() {
    $this->checkType();
    $_roleInstance = $this->getEntityInstance();
    $_roleHandler = $this->getRoleHandler();
    $model = $_roleHandler->getModifyAccountInstance($_roleInstance);
    $pageToRender = $_roleHandler->getModifyPage();

    $request_data = Yii::$app->request->post();

    //-
    $reflect = new ReflectionClass($model);
    $className = $reflect->getShortName();
    if (array_key_exists($className, $request_data)
      && !$model->differencesBetweenData($request_data[$className])) {
      return $this->redirect(['site/account']);
    }

    if ($model->load($request_data)) {      
      if ($model->saveData()) {
        $success_message = 'Modifica effettuata con successo';
        Yii::$app->session->setFlash('success', $success_message);
        return $this->redirect(['site/account']);
      } 
      else {
        $error_message = 'Qualcosa è andato storto nella modifica dei dati. Riprova';
        Yii::$app->session->setFlash('error', $error_message);
        return $this->redirect($pageToRender, [
          'model' => $model
        ]);
      }
    }

    return $this->render($pageToRender, [
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
  private function getRoleHandler() {
    return ActionRulesHandler::getRoleHandler();
  }
  private function getRoleHandlerByType($type) {
    return ActionRulesHandler::getRoleHandlerByType($type);
  }

   

  /**
   * {@inheritdoc}
   */
  public function beforeAction($action)
  {
    /* code for overriding */
    if (!parent::beforeAction($action)) {
      return false;
    }

    /* code to check the role */
    $result = ActionRulesHandler::checkControllerRule($this->controllerRole);
    $resultType = gettype($result);

    if ($resultType == 'string') {
      $this->redirect([$result]);
      $result = true;
    }

    return $result;
  }
}
