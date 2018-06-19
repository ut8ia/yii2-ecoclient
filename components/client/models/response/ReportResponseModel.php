<?php

namespace ut8ia\ecoclient\components\client\models\response;

use ut8ia\ecoclient\components\client\models\data\ReportResponseDataModel;
use Yii;
use yii\base\Model;

class ReportResponseModel extends Model
{

    public $data;
    public $hash;

    private $dataModel;

    public function rules()
    {
        return [
            [['data', 'hash'], 'required'],
            ['data', 'validateData'],
            ['hash', 'checkHash']
        ];
    }

    /**
     * @return bool
     */
    public function checkHash()
    {
        $computedHash = hash_hmac(
            'md5',
            json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            Yii::$app->params['ecoclient']['hashkey']
        );

        if ($this->hash === $computedHash) {
            return true;
        }
        $this->addError('Hash is not valid');
        return false;
    }


    /**
     * @return bool
     */
    public function validateData()
    {
        $this->dataModel = new ReportResponseDataModel();
        $this->dataModel->load(['ReportResponseDataModel' => $this->data]);
        if ($this->dataModel->validate()) {
            return true;
        }
        $this->addError('data error' . $this->dataModel->errors[0]);
        return false;
    }


}