<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "api".
 *
 * @property integer $id
 * @property string $name
 * @property string $endpoint
 * @property string $access
 * @property string $params
 * @property string $requirement
 * @property string $category
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property ApiStatus $apiStatus
 */
class Api extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['updated_at', 'created_at'], 'integer'],
            [['name', 'endpoint', 'access', 'params', 'requirement', 'category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'endpoint' => 'Endpoint',
            'access' => 'Access',
            'params' => 'Params',
            'requirement' => 'Requirement',
            'category' => 'Category',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApiStatus()
    {
        return $this->hasOne(ApiStatus::className(), ['api_id' => 'id']);
    }
}

