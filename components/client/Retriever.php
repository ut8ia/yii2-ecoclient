<?php

namespace ut8ia\ecoclient\components\client;

use ut8ia\ecoclient\components\client\models\response\CityreportsResponseModel;
use ut8ia\ecoclient\components\client\models\response\ReportResponseModel;
use ut8ia\ecoclient\components\client\models\response\UnitsResponseModel;
use ut8ia\ecoclient\models\Parameters;
use ut8ia\ecoclient\models\Reports;
use ut8ia\ecoclient\models\Units;

/**
 * Class Retriever
 * @package ut8ia\ecoclient\client
 */
class Retriever
{

    /**
     * @var Client
     */
    public $client;

    const ENDPOINT_REPORT = '/v1/report';
    const ENDPOINT_CITY = '/v1/city';
    const ENDPOINT_CITYREPORTS = '/v1/cityreport';


    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchUnits($cityId)
    {
        $this->client->endpoint = self::ENDPOINT_CITY . '/' . $cityId;
        $this->client->responseModel = new UnitsResponseModel();
        if (!$this->client->makeRequest()) {
            return $this->client->responseModel->errors;
        }

        foreach ($this->client->responseModel->getUnits() as $unit) {
            $this->loadUnit($unit);
        }

        return true;
    }

    /**
     * @param integer $cityId
     *
     * @return bool|array
     */
    public function fetchCityreports($cityId)
    {
        $this->client->endpoint = self::ENDPOINT_CITYREPORTS . '/' . $cityId;
        $this->client->responseModel = new CityreportsResponseModel();
        if (!$this->client->makeRequest()) {
            return $this->client->responseModel->errors;
        }

        foreach ($this->client->responseModel->data as $report) {
            $found = Reports::findOne(['id' => $report['id']]);
            if (!$found) {
                $this->fetchReport($report['id']);
            }
        };

        return true;
    }


    /**
     * @param $reportId
     * @return bool|array
     */
    public function fetchReport($reportId)
    {

        $this->client->endpoint = self::ENDPOINT_REPORT . '/' . $reportId;
        $this->client->responseModel = new ReportResponseModel();
        if (!$this->client->makeRequest()) {
            return $this->client->responseModel->errors[0];
        }

        return $this->loadReport($this->client->responseModel->data);
    }

    private function loadUnit($unit)
    {
        $storedUnit = Units::findOne($unit['id']);
        if (empty($storedUnit)) {
            $storedUnit = new Units($unit);
            $storedUnit->save();
        } else {
            $storedUnit->updateAttributes($unit);
        }
    }


    /**
     * @param array $data
     * @return bool
     */
    private function loadReport($data)
    {

        $report = new Reports();
        $report->id = $data['report']['id'];
        $report->unit_id = $data['report']['unit_id'];
        $report->formed = $data['report']['formed'];
        if (!$report->save()) {
            return false;
        }


        foreach ($data['parameters'] as $type => $value) {

            Parameters::addRecord(
                $type,
                $value,
                $report->id
            );

        }
        return true;

    }


}