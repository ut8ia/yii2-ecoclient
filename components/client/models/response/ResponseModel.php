<?php

namespace ut8ia\ecoclient\components\client\models\response;

use yii\base\Model;

abstract class ResponseModel extends Model
{

    public $data;

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        $this->data = $data[$this->formName()];
        return true;
    }

}
