<?php

namespace ut8ia\ecoclient\client;

use ut8ia\ecoclient\client\models\CityreportsResponseModel;
use yii\base\BaseObject;
use Yii;

/**
 * Class Retriever
 * @package ut8ia\ecoclient\client
 */
class Retriever extends BaseObject
{

    /**
     * @var Client
     */
    private $client;

    const ENDPOINT_REPORT = '/v1/report';
    const ENDPOINT_CITYREPORTS = '/v1/cityreports';


    public function init()
    {
        $this->client = new Client();
    }

    public function fetchCityreports($cityId)
    {
        $this->client->endpoint = self::ENDPOINT_CITYREPORTS.'/'.$cityId;
        $this->client->responseModel = new CityreportsResponseModel();
        $this->client->makeRequest();
        dd($this->client->responseModel->data);
    }


}