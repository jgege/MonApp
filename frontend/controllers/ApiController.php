<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Api;
use common\models\ApiStatus;

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
        return $this->actionStatus();
    }

    public function actionStatus()
    {
        $modelList = Api::find()
            ->select(
                [
                    'id' => 'id',
                    'name' => 'api.name',
                    'last_time_checked' => 'FROM_UNIXTIME(request_sent_at)',
                    'last_time_working' => 'FROM_UNIXTIME(api_status.updated_at)',
                    'status' => 'IF(COALESCE(api_status_code, http_status) = "200", "ok", "error")',
                    'latency' => 'latency',
                ]
            )
            ->join('INNER JOIN', 'api_status', 'api_status.api_id = api.id')
            ->asArray()
            ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $modelList;
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
