<?php

namespace app\controllers;

use Yii;
use yii\debug\models\search\Db;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPortal ()
    {
        return $this->render('portal');
    }

    public function actionDrug_lookup ()
    {
        $connection = new \yii\db\Connection([
            'dsn' => 'sqlite:..\pharmaceuticals.sqlite'
        ]);
        $connection->open();
        $command = $connection->createCommand('SELECT * FROM drugs');
        $drugs = $command->queryAll();
        $command = $connection->createCommand('SELECT * FROM brands');
        $brands = $command->queryAll();
        $command = $connection->createCommand('SELECT * FROM drug_interactions');
        $interactions = $command->queryAll();
        $command = $connection->createCommand('SELECT * FROM severities');
        $severities = $command->queryAll();
        return $this->render('drug_lookup', ['drugs'=>$drugs, 'brands'=>$brands, 'interactions' =>$interactions, 'severities'=>$severities]);
    }
    public function actionAbout_trials ()
    {
        return $this->render('about_trials');
    }
    public function actionTrial_lookup ()
    {
        $connection = new \yii\db\Connection([
            'dsn' => 'sqlite:..\pharmaceuticals.sqlite'
        ]);
        $connection->open();
        $command = $connection->createCommand('SELECT * FROM clinical_trials');
        $trials = $command->queryAll();
        return $this->render('trial_lookup',['trials'=>$trials]);
    }
    public function actionPrescriptions ()
    {
        $connection = new \yii\db\Connection([
            'dsn' => 'sqlite:..\pharmaceuticals.sqlite'
        ]);
        $connection->open();
        $sql = <<<SQLITE
select U.user_drug_id, U.user_id, D.drug_id, D.drug_name, P.prescription_days, P.prescription_times
from user_drugs U
left join drugs D on U.drug_id = D.drug_id
left join prescriptions P on U.user_drug_id = P.user_drug_id
where U.user_id = 1
SQLITE;
;
        $command = $connection->createCommand($sql);
        $prescriptions = $command->queryAll();
        $command = $connection->createCommand('SELECT * FROM drug_interactions');
        $interactions = $command->queryAll();
        $command = $connection->createCommand('SELECT * FROM severities');
        $severities = $command->queryAll();
        $command = $connection->createCommand('SELECT * FROM drugs');
        $drugs = $command->queryAll();
        return $this->render('prescriptions',['prescriptions'=>$prescriptions,'interactions'=>$interactions, 'severities'=>$severities, 'drugs'=>$drugs]);
    }
}
