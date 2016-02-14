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
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $modelList = Api::find()->joinWith(['apiStatus'])->all();

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
