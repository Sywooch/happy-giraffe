<?php

namespace site\frontend\modules\questionnaire\models;

class QuestionnaireForm extends \CFormModel
{
    public $text;
    private $user_id;

    public function init()
    {
        $this->user_id = \Yii::app()->user->getId();
    }

    public function rules()
    {
        return array(
            array('text', 'required'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'text' => 'Заголовок'
        );
    }
}