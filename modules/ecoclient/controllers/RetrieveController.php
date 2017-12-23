<?php

namespace ut8ia\ecoclient\modules\ecoclient\controllers;

use ut8ia\ecoclient\Client;
use ut8ia\ecoclient\client\Retriever;
use Yii;
use yii\console\Controller;
use ut8ia\ecoclient\models\Reports;

/**
 * Console hook controller for data retrieveing
 * @package console\controllers
 */
class RetrieveController extends Controller
{


    public function actionCityreport()
    {
        $retriver = new Retriever();
        $retriver->fetchCityreports(1);
    }


}
