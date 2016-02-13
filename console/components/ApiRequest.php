<?php namespace console\components;

use common\models\Api;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use common\models\ApiStatus;

class ApiRequest extends Component
{
    public $baseUrl = 'http://dogfish.tech/api/';
    public $tokenUrl = 'http://dogfish.tech/api/login';
    public $apiUserName = 'stirling';
    public $apiPassword = 'stir';
    public $apiAuthKey = 'stir';

    public $breakIt = null;

    public function checkApiStatus(Api $model, $token = '')
    {
        $result = $this->sendRequest($model, $token);

        $statusModel = $this->getApiStatusModel($model);
        $statusModel->http_status = (string) $result['statusCode'];
        $statusModel->request_sent_at = $result['requestSentAt'];
        $statusModel->latency = (int) ($result['latency'] * 1000);
        $statusModel->api_status_code = null;
        $statusModel->valid_data = null;

        if ($result['statusCode'] == 200 && isset($result['result'])) {
            try {
                $json = Json::decode($result['result']);
            } catch (Exception $e) {
                $json = [];
            } catch (yii\base\InvalidParamException $e) {
                $json = [];
            }

            if (empty($json)) {
                $statusModel->valid_json = 0;
            } else {
                $statusModel->api_status_code = (string) $json['headers']['response_code'];
                $statusModel->valid_json = 1;
            }
        }

        if ($statusModel->save() == false) {
            var_dump($statusModel->getErrors());
            exit();
        }

        return $statusModel;
    }

    public function getToken()
    {
        $url = $this->tokenUrl . '?user=' . $this->apiUserName . '&password=' . $this->apiPassword;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode != 200) {
            return null;
        }

        try {
            $json = Json::decode($result);
        } catch ( Exception $e) {
            $json = [];
        }

        if (!isset($json['data'])) {
            return null;
        }

        if (!isset($json['data']['token'])) {
            return null;
        }

        return $json['data']['token'];
    }

    private function getApiStatusModel(Api $model)
    {
        $statusModel = ApiStatus::find()
            ->where(['api_id' => $model->id])
            ->one();

        if ($statusModel == null) {
            $statusModel = new ApiStatus();
            $statusModel->api_id = $model->id;
        }

        return $statusModel;
    }

    private function sendRequest(Api $model, $token)
    {
        $url = $this->baseUrl . urldecode($model->endpoint) . '/';
        if ($model->params) {
            $url .=  urldecode($model->params);
        }

        if ($model->access == $model::ACCESS_TYPE_TOKEN && $token) {
            $url = $this->addTokenToUrl($url, $token);
        } else if($model->access == $model::ACCESS_TYPE_AUTH) {
            $url = $this->addAuthkeyToUrl($url, $this->apiAuthKey);
        }

        if ($this->breakIt === true) {
            $url = $this->modifyUrlMakeItBroke($url);
        } else if ($this->breakIt === false) {
            $url = $this->modifyUrlMakeItWork($url);
        }

        echo 'Sending request: ' . $url . PHP_EOL;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $timeStart = microtime(true);
        $requestSentAt = time();
        $result = curl_exec($ch);
        $latency = microtime(true) - $timeStart;
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo 'Latency: ' . $latency. 'ms' . PHP_EOL;

        return [
            'result' => $result,
            'statusCode' => $statusCode,
            'latency' => $latency,
            'requestSentAt' => $requestSentAt
        ];
    }

    private function addTokenToUrl($url, $token)
    {
        return $url .= ((strpos($url, '?')) ? '&' : '?') . 'token=' . urlencode($token);
    }

    private function addAuthkeyToUrl($url, $authkey)
    {
        return $url .= ((strpos($url, '?')) ? '&' : '?') . 'auth=' . urlencode($authkey);
    }

    private function modifyUrlMakeItBroke($url) {
        return $url .= ((strpos($url, '?')) ? '&' : '?') . 'broken=1';
    }

    private function modifyUrlMakeItWork($url) {
        return $url .= ((strpos($url, '?')) ? '&' : '?') . 'working=1';
    }
}
