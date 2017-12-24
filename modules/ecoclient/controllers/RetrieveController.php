<?php

namespace ut8ia\ecoclient\modules\ecoclient\controllers;


use ut8ia\ecoclient\components\client\Retriever;
use yii\console\Controller;

/**
 * Console hook controller for data retrieveing
 * @package console\controllers
 */
class RetrieveController extends Controller
{

    /**
     * @param integer $cityId
     */
    public function actionCityreport($cityId)
    {
        $retriver = new Retriever();
        $retriver->fetchCityreports($cityId);
    }


}
