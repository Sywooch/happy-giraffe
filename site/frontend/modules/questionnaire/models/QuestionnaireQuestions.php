<?php

namespace site\frontend\modules\questionnaire\models;

use site\frontend\modules\questionnaire\models\QuestionnaireAnswers;

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

class QuestionnaireQuestions extends \HActiveRecord
{
   // public $answers;

    public function init()
    {
        //$this->answers = $this->getAnswers();
    }

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
        return array(
            //'answers' => array(self::HAS_MANY, 'QuestionnaireAnswers', 'question_id'),
        );
    }

    public function rules()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array();
    }

    public function getAnswers()
    {
        return QuestionnaireAnswers::model()->findAll("question_id = :id", array(':id' => $this->id));
    }
}