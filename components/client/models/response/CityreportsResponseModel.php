<?php

namespace ut8ia\ecoclient\components\client\models\response;


class CityreportsResponseModel extends ResponseModel
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

        foreach ($this->data as $report) {
            if (isset($report['id']) && isset($report['unit_id']) && isset($report['formed'])) {
                continue;
            }
            $this->addError('bad schema');
            return false;
        }
        return true;
    }


}