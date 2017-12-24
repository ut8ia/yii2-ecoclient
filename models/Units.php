<?php

namespace ut8ia\ecoclient\models;

use Yii;

/**
 * This is the model class for table "units".
 *
 * @property int $id
 * @property int $city_id
 * @property string $lattitude
 * @property string $longitude
 * @property string $status
 * @property string $comment
 */
class Units extends \yii\db\ActiveRecord
{


    const STATUS_ACTIVE = 'active';
    const STATUS_PASSIVE = 'passive';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{units}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'lattitude', 'longitude', 'status'], 'required'],
            [['city_id'], 'integer'],
            [['status'], 'string'],
            [['apikey', 'lattitude', 'longitude'], 'string', 'max' => 32],
            [['hashkey'], 'string', 'max' => 16],
            [['comment'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'lattitude' => Yii::t('app', 'Lattitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'status' => Yii::t('app', 'Status'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }


}
