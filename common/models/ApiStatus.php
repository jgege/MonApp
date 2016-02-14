<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "api_status".
 *
 * @property integer $api_id
 * @property integer $valid_json
 * @property integer $valid_data
 * @property string $http_status
 * @property string $api_status_code
 * @property integer $request_sent_at
 * @property integer $latency
 * @property integer $last_time_worked_at
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property Api $api
 */
class ApiStatus extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['api_id'], 'required'],
            [['api_id', 'valid_json', 'valid_data', 'request_sent_at', 'latency', 'last_time_worked_at', 'updated_at', 'created_at'], 'integer'],
            [['api_status_code', 'http_status'], 'string', 'max' => 255],
            [['api_id'], 'unique'],
            [['api_id'], 'exist', 'skipOnError' => true, 'targetClass' => Api::className(), 'targetAttribute' => ['api_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'api_id' => 'Api ID',
            'api_status_code' => 'API Status Code',
            'valid_json' => 'Valid Json',
            'valid_data' => 'Valid Data',
            'http_status' => 'Http Status',
            'request_sent_at' => 'Request Sent At',
            'latency' => 'Latency',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApi()
    {
        return $this->hasOne(Api::className(), ['id' => 'api_id']);
    }
}

