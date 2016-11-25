<?php

namespace site\frontend\modules\questionnaire\models;

/**
  * @property int $id
  * @property int $question_id
  * @property int $questionnaire_id
  * @property string $text
  * @property int $result_id
  */
class QuestionnaireAnswers extends \HActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'questionnaire_answers';
    }

    public function primaryKey()
    {
        return 'id';
    }

    public function relations()
    {
        return array();
    }

    public function rules()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array();
    }

    public function getResult()
    {
        return QuestionnaireResults::model()->findByPk($this->result_id);
    }
}