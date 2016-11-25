<?php

namespace site\frontend\modules\questionnaire\models;

use site\frontend\modules\photo\models\Photo;

/**
 * @property int $id (primary, ai)
 * @property string $name (varchar 255)
 * @property int $user_id
 *
 * @foreign_key questionnaire_author ['user_id' => Users::id]
 * @index user_id -> $user_id
 */

class Questionnaire extends \HActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'questionnaire';
    }

    public function relations()
    {
        /*return array(
            'author' => array(self::HAS_ONE, 'Users', array('id' => 'user_id')),
        );*/
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

    public function getResults()
    {
        $results = QuestionnaireResults::model()->findAll("questionnaire_id = :id", array(':id' => $this->id));

        foreach ($results as $result){
            if ($result->type == 1){
                $result->photo = Photo::model()->findByPk((int)$result->value);
            }
        }

        return $results;
    }

    public function getQuestions()
    {
        return QuestionnaireQuestions::model()->findAll("questionnaire_id = :id", array(':id' => $this->id));
    }
}