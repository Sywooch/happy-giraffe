<?php

namespace site\frontend\modules\stream\models;

class Stream extends CModel
{
    public function send($data)
    {
        Yii::app()->nginxStream->send('talk', $data);
    }
}