<?php

namespace ut8ia\ecoclient\modules\ecoclient;

use yii\base\Module;
use Yii;
/**
 * Class Ecoclient
 * @package ut8ia\ecoclient\modules\ecoclient
 */
class Ecoclient extends Module
{

    
    public function init()
    {
        Yii::setAlias('ut8ia', $this->getBasePath());
        parent::init();
    }


}