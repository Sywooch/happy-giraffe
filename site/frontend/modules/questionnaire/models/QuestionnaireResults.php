<?php

namespace site\frontend\modules\questionnaire\models;

/**
 * @property int $id (primary, ai)
 * @property int $questionnaire_id
 * @property bool type (0 - text, 1 - image)
 * @property string $value
 *
 * @foreign_key questionnaire_results_ibfk_1 ['questionnaire_id' => Questionnaire::id]
 * @index questionnaire_result -> $questionnaire_id
 */

class QuestionnaireResults extends \HActiveRecord
{
    public $photo = null;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'questionnaire_results';
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