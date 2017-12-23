<?php

namespace ut8ia\ecoclient\models;

use Yii;

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
        return 'reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id'], 'required'],
            [['unit_id'], 'integer'],
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
     * @param $formed
     * @return Reports
     */
    public function makeReport($formed)
    {
        $this->formed = $formed;
        $this->unit_id = Yii::$app->user->identity->id;
        return $this->save();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(Parameters::class, ['report_id' => 'id']);
    }


}