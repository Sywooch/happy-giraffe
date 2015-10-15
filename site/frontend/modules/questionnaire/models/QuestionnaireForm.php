<?php

namespace site\frontend\modules\questionnaire\models;

class QuestionnaireForm extends \CFormModel
{
    public $text;
    private $user_id;

    protected $_formConfig = array();

    private $_defaultFormConfig = array(
        'method' => 'post',
        'enctype' => 'multipart/form-data',
    );

    public function init()
    {
        $this->user_id = \Yii::app()->user->getId();
        $this->_setFormConfig();
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

    public function _setFormConfig()
    {
        $this->_formConfig = array_replace_recursive($this->_defaultFormConfig, $this->_formConfig);
    }
}