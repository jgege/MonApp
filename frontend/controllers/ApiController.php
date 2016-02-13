<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Api controller
 */
class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['status'],
                /*'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],*/
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    public function actionIndex()
    {
        $this->actionStatus();
    }

    public function actionStatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = [
            'api1' => [
                'id' => 1,
                'name' => 'api1',
                'last_time_checked' => '2016.02.13 12:13:14',
                'last_time_working' => '2016.02.03 10:11:12',
                'latency' => 12,
            ],
            'api2' => [
                'id' => 2,
                'name' => 'api2',
                'last_time_checked' => '2016.02.13 12:13:14',
                'last_time_working' => '2016.02.03 10:11:12',
                'latency' => 12,
            ],
            'api3' => [
                'id' => 3,
                'name' => 'api3',
                'last_time_checked' => '2016.02.13 12:13:14',
                'last_time_working' => '2016.02.03 10:11:12',
                'latency' => 12,
            ],
        ];

        return $this->render($data);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}
