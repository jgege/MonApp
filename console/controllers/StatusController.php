<?php namespace console\controllers;

use common\models\Api;
use console\components\ApiRequest;
use yii\console\Controller;

class StatusController extends Controller
{

    public function actionIndex($id)
    {
        $model = Api::find()
            ->where(['id' => $id])
            ->one();

        if ($model == null) {
            return 'Unknown API id.' . PHP_EOL;
        }

        $apiStatus = new ApiRequest();
        $status = $apiStatus->checkApiStatus($model);
    }

    public function actionAllApi()
    {
        $modelList = Api::find()
            //->joinWith(['apiStatus'])
            //->orderBy(['apiStatus.latency' => SORT_DESC])
            ->all();

        $apiRequest = new ApiRequest();
        $token = $apiRequest->getToken();
        //$apiRequest->breakIt = true;
        echo "Token: " . $token . PHP_EOL;
        foreach ($modelList as $model) {
            $apiRequest->checkApiStatus($model, $token);
        }
    }
}
