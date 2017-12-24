<?php

namespace ut8ia\ecoclient\models;

use Yii;

/**
 * This is the model class for table "parameters".
 *
 * @property int $id
 * @property string $type
 * @property int $value
 * @property int $report_id
 */
class Parameters extends \yii\db\ActiveRecord
{

    const TYPE_TEMPERATURE = 'temperature';
    const TYPE_HUMIDITY = 'humidity';
    const TYPE_DUST10 = 'dust10';
    const TYPE_DUST25 = 'dust25';
    const TYPE_GAS = 'gas';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{parameters}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'value', 'report_id'], 'required'],
            [['type'], 'string'],
            [['value', 'report_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'value' => Yii::t('app', 'Value'),
            'report_id' => Yii::t('app', 'Report ID'),
        ];
    }


    /**
     * @param string $type
     * @param integer $value
     * @param integer $reportId
     * @return bool
     */
    public static function addRecord($type, $value, $reportId)
    {
        $param = new Parameters();
        $param->type = $type;
        $param->value = $value;
        $param->report_id = $reportId;
        return $param->save();
    }

}
