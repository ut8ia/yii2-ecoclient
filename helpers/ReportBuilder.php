<?php

namespace ut8ia\ecoclient\helpers;

use DateTime;
use ut8ia\ecoclient\models\Parameters;
use ut8ia\ecoclient\models\Reports;

/**
 * Class ReportHelper
 * @package common\helpers
 */
class ReportBuilder
{

    /**
     * @var DateTime
     */
    private $firstTimelinePoint;
    private $labels = [];
    private $temperature = [];
    private $humidity = [];
    private $dust10 = [];
    private $dust25 = [];
    private $gas = [];

    /** @var array $reports */
    private $reports;

    /**
     * possible parameter types
     */
    const PARAM_TYPES = [
        Parameters::TYPE_TEMPERATURE,
        Parameters::TYPE_HUMIDITY,
        Parameters::TYPE_DUST10,
        Parameters::TYPE_DUST25,
        Parameters::TYPE_GAS
    ];

    /**
     * @return int
     */
    public function makeReport()
    {
        $this->findReports();
        if (empty($this->reports)) {
            return 0;
        }
        return $this->processReports();
    }

    /** @return array */
    public function getLabels()
    {
        return $this->labels;
    }

    /** @return array */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /** @return array */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /** @return array */
    public function getDust25()
    {
        return $this->dust25;
    }

    /** @return array */
    public function getDust10()
    {
        return $this->dust10;
    }

    /** @return array */
    public function getGas()
    {
        return $this->gas;
    }

    /**
     * @return int
     */
    private function processReports()
    {
        $count = 0;
        /** @var $report Reports */
        foreach ($this->reports as $report) {
            $this->processParams($report);
            $this->labels[] = $report->formed;
            $count++;
        }
        return $count;
    }

    /**
     * @param Reports $report
     */
    private function processParams(Reports $report)
    {
        $types = self::PARAM_TYPES;
        if (null !== $report->parameters) {
            /** @var $parameter Parameters */
            foreach ($report->parameters as $parameter) {
                $this->{$parameter->type}[] = $parameter->value;
                unset($types[array_search($parameter->type, $types, false)]);
            }
        }

        $this->fillEmpty($types);
    }

    /**
     * @param array $names
     */
    private function fillEmpty($names = [])
    {
        foreach ($names as $name) {
            $this->$name[] = null;
        }
    }


    private function findReports()
    {
        $this->reports = Reports::find()
            ->with('parameters')
            ->where(['>=', 'formed', $this->getFirstTimelinePoint()->format(DateTime::ISO8601)])
            ->orderBy(['formed' => SORT_ASC])
            ->all();
    }

    /**
     * Sets the value for the start point of the report time scale
     * @param $time date/time string according to http://php.net/manual/ru/datetime.formats.php
     */
    public function setFirstTimelinePoint($time)
    {
        $this->firstTimelinePoint = new DateTime($time);
    }

    /**
     * @return DateTime
     */
    private function getFirstTimelinePoint()
    {
        if (empty($this->firstTimelinePoint)) {
            $this->firstTimelinePoint = new DateTime('yesterday');
        }
        return $this->firstTimelinePoint;
    }


}
