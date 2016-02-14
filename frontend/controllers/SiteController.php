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
use common\models\ApiSearch;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $modelList = Api::find()
            ->select(
                [
                    'id' => 'id',
                    'name' => 'api.name',
                    'last_time_checked' => 'FROM_UNIXTIME(request_sent_at)',
                    'last_time_working' => 'FROM_UNIXTIME(api_status.last_time_worked_at)',
                    'status' => 'IF(COALESCE(api_status_code, http_status) = "200", "ok", "error")',
                    'latency' => 'latency',
                ]
            )
            ->joinWith(['apiStatus'])
            ->all();

        return $this->render('index', ['modelList' => $modelList]);
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
