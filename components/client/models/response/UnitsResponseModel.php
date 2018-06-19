<?php

namespace ut8ia\ecoclient\components\client\models\response;


class UnitsResponseModel extends ResponseModel
{

    public $data;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['data', 'checkReports'],
        ];
    }

    /**
     * Simple validator, no need for DTO model for each badge - may be slow on big pages
     * like iterator of 'IN' core validator
     * @return bool
     */
    public function checkReports()
    {
        if (empty($this->data)) {
            $this->addError('empty set');
            return false;
        }
        if (!isset($this->data['data']['units']) && !is_array($this->data['data']['units'])) {
            $this->addError('empty units data');
            return false;
        }
        
        return true;
    }

    public function getUnits()
    {
        return $this->data['data']['units'];
    }


}
