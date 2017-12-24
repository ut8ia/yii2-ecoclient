<?php

namespace ut8ia\ecoclient\components\client\models\data;


use ut8ia\ecoclient\models\Parameters;
use yii\base\Model;

/**
 * Class  ResponseDataModel
 * @package ut8ia\ecoclient\client\models\data
 *
 * @property integer $mktime
 * @property array $report
 * @property array $parameters
 */
class ReportResponseDataModel extends Model
{

    public $mktime;
    public $report;
    public $parameters;


    public $validTypes = [
        Parameters::TYPE_DUST25,
        Parameters::TYPE_DUST10,
        Parameters::TYPE_HUMIDITY,
        Parameters::TYPE_TEMPERATURE,
        Parameters::TYPE_GAS
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mktime', 'report', 'parameters'], 'required'],
            ['mktime', 'integer'],
            ['parameters', 'checkParameters'],
            ['report', 'checkReport']
        ];
    }


    /**
     * @return bool
     */
    public function checkParameters()
    {
        if (empty($this->parameters)) {
            $this->addError('empty parameters set');
            return false;
        }

        foreach ($this->parameters as $ind => $val) {
            if (!in_array($ind, $this->validTypes)) {
                $this->addError('unknown parameter ' . $ind);
                return false;
            }

            if (!is_int($val)) {
                $this->addError('bad parameter value type');
                return false;
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function checkReport()
    {
        if (isset($this->report['id'], $this->report['unit_id'], $this->report['formed'], $this->report['received'])) {
            return true;
        }
        $this->addError('bad report schema');
        return false;
    }


}