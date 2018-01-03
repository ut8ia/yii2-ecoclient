<?php

namespace ut8ia\ecoclient\modules\ecoclient\controllers;

use ut8ia\ecoclient\helpers\CommonHelper;
use ut8ia\ecoclient\helpers\ReportBuilder;
use yii\base\InvalidParamException;
use yii\web\Controller;

/**
 * Site controller
 */
class DisplayController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     * @throws InvalidParamException
     */
    public function actionIndex()
    {
        $report = new ReportBuilder();
        $report->setFirstTimelinePoint('yesterday');
        $report->makeReport();

        return $this->render('index',
            [
                'labels' => $report->getLabels(),
                'temperature' => CommonHelper::arrayMult($report->getTemperature(),0.1),
                'humidity' => CommonHelper::arrayMult($report->getHumidity(),0.1),
                'dust25' => $report->getDust25(),
                'dust10' => $report->getDust10(),
                'gas' => $report->getGas()
            ]
        );
    }

}
