<?php

namespace site\frontend\modules\questionnaire\models;

/**
 * @property int $id (primary, ai)
 * @property int $questionnaire_id
 * @property int stage
 * @property string $text (varchar 255)
 * @property int $result_id
 *
 * @foreign_key questionnaire_question ['questionnaire_id' => Questionnaire::id]
 * @foreign_key questionnaire_question_result ['result_id' => QuestionnaireResults::id]
 * @index questionnaire_question -> $questionnaire_id
 * @index questionnaire_question_result -> $result_id
 */

class QuestionnaireQuestions extends \CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'questionnaire_questions';
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
}