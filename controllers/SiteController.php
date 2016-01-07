<?php

namespace app\controllers;

use app\components\CommonController;
use app\components\enums\StatusEnum;
use app\models\Issue;
use app\models\Settings;
use app\models\search\IssueSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class SiteController extends CommonController
{
    const ISSUE_LIMIT = 20;
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
        $searchModel = new IssueSearch();
        if (is_null(Yii::$app->authManager->getAssignment(User::ROLE_ADMIN, Yii::$app->user->getId()))) {
            $searchModel->assignee_id = Yii::$app->user->getId();
        }
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetIssuesJson()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'New' => Issue::find()->where('status_id IN ('.implode(',', StatusEnum::getOpenStatuses()).')')->orderBy('id DESC')->limit(self::ISSUE_LIMIT)->all(),
            'In work' => Issue::find()->where(['status_id' => StatusEnum::IN_WORK])->orderBy('id DESC')->limit(self::ISSUE_LIMIT)->all(),
            'Closed' => Issue::find()->where('status_id IN ('.implode(',', StatusEnum::getClosedStatuses()).')')->orderBy('id DESC')->limit(self::ISSUE_LIMIT)->all(),
        ];
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionQwe()
    {
        \Yii::$app->cache->flush();
        die('qwe');
    }
}
