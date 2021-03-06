<?php

namespace ut8ia\ecoclient\models;

use ut8ia\ecoclient\modules\ecoclient\Ecoclient;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reports".
 *
 * @property int $id
 * @property int $unit_id
 * @property string $formed
 * @property string $received
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $dbTablesPrefix = ArrayHelper::getValue(Yii::$app->params, 'ecoclient.dbTablesPrefix', Ecoclient::defaultDbTablesPrefix);
        return str_replace('%', $dbTablesPrefix, '{{%reports}}');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'unit_id', 'formed'], 'required'],
            [['id', 'unit_id'], 'integer'],
            [['formed', 'received'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'unit_id' => Yii::t('app', 'Unit ID'),
            'formed' => Yii::t('app', 'Formed'),
            'received' => Yii::t('app', 'Received'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(Parameters::class, ['report_id' => 'id']);
    }


}
