<?php

namespace ut8ia\ecoclient\components\client;

use Yii;
use yii\base\Model;

/**
 * Class Client
 * @package ut8ia\ecoclient\client
 */
class Client extends Model
{

    private $host;
    private $key;
    public $endpoint;
    public $body;
    /** @var  $responseModel Model */
    public $responseModel;

    public function __construct()
    {
        $this->host = Yii::$app->params['ecoclient']['apihost'];
        $this->key = Yii::$app->params['ecoclient']['apikey'];
    }

    /**
     * @param null $post
     * @return bool
     */
    public function makeRequest($post = null)
    {

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->key];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $this->host . $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        if ($post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        $response = curl_exec($ch);
        if (false === $response) {
            $info = curl_getinfo($ch,  CURLINFO_EFFECTIVE_URL);
            $this->addError($info, 'error making request');
            return false;
        }
        
        return $this->catchResponse($response);
    }


    /**
     * @param $response
     * @return boolean
     */
    private function catchResponse($response)
    {
        $this->responseModel->load([$this->responseModel->formName() => json_decode($response, true)]);
        return $this->responseModel->validate();
    }


}