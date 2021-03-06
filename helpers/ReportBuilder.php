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

    public $dateFormat = 'd.m.Y';
    public $dateTimeFormat = 'd.m.Y H:i';
    public $formatSwitchCount = 10000;

    /** @var DateTime */
    private $firstTimelinePoint;
    /** @var DateTime */
    private $lastTimelinePoint;
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
     * @param int $unitId
     * @return ReportBuilder
     */
    public function makeReport($unitId)
    {

        $this->findReports($unitId);
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

    public function getCount()
    {
        return count($this->labels);
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
        $count = count($this->reports);
        $format = ($count > $this->formatSwitchCount) ? $this->dateFormat : $this->dateTimeFormat;
        /** @var $report Reports */
        foreach ($this->reports as $report) {
            $this->processParams($report);
            $this->labels[] = date($format, strtotime($report->formed));
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

    private function findReports($unitId)
    {
        $this->reports = Reports::find()
            ->with('parameters')
            ->where(
                [
                    'and',
                    ['>=', 'formed', $this->getFirstTimelinePoint()->format(DateTime::ATOM)],
                    ['<=', 'formed', $this->getLastTimelinePoint()->format(DateTime::ATOM)]
                ])
            ->andWhere(['unit_id' => $unitId])
            ->orderBy(['formed' => SORT_ASC])
            ->all();
    }

    /**
     * Sets the value for the start point of the report time scale
     * @param $time date/time string according to http://php.net/manual/ru/datetime.formats.php
     * @return ReportBuilder
     */
    public function setFirstTimelinePoint($time)
    {
        $this->firstTimelinePoint = new DateTime($time);
        return $this;
    }

    /**
     * Начало шкалы времени. По умолчанию - начало предыдущих суток
     * @return DateTime
     */
    private function getFirstTimelinePoint()
    {
        if (empty($this->firstTimelinePoint)) {
            $this->firstTimelinePoint = new DateTime('yesterday');
        }
        return $this->firstTimelinePoint;
    }

    /**
     * Sets the value for the start point of the report time scale
     * @param $time date/time string according to http://php.net/manual/ru/datetime.formats.php
     * @return ReportBuilder
     */
    public function setLastTimelinePoint($time)
    {
        $this->lastTimelinePoint = new DateTime($time);
        return $this;
    }

    /**
     * @return DateTime
     */
    private function getLastTimelinePoint()
    {
        if (empty($this->lastTimelinePoint)) {
            $this->lastTimelinePoint = new DateTime('now');
        }
        return $this->lastTimelinePoint;
    }

}
