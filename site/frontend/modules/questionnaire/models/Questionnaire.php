<?php

namespace site\frontend\modules\questionnaire\models;

/**
 * @property int $id (primary, ai)
 * @property string $name (varchar 255)
 * @property int $user_id
 *
 * @foreign_key questionnaire_author ['user_id' => Users::id]
 * @index user_id -> $user_id
 */

class Questionnaire extends \CActiveRecord
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
}