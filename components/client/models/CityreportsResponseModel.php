<?php

namespace ut8ia\ecoclient\client\models;

use yii\base\Model;

class CityreportsResponseModel extends Model
{

    public $data;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['data', 'required'],
        ];
    }

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