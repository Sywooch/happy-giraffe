<?php

namespace site\frontend\modules\specialists\modules\pediatrician\components;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * @author Никита
 * @date 16/08/16
 */
class QaManager
{
    public static function getQuestionsDp()
    {
        return new \CActiveDataProvider(QaQuestion::model()->orderDesc()->apiWith('user'), [
            'criteria' => self::getQuestionsCriteria(),
        ]);
    }
    
    public static function getQuestionsCount()
    {
        return QaQuestion::model()->count(self::getQuestionsCriteria());
    }

    public static function getAnswersDp($userId)
    {
        return new \CActiveDataProvider(QaAnswer::model()->orderDesc()->apiWith('user'), [
            'criteria' => self::getAnswersCriteria($userId),
        ]);
    }
    
    protected static function getAnswersCriteria($userId)
    {
        $criteria = new \CDbCriteria();
        $criteria->scopes = ['category' => [self::getCategoryId()]];
        $criteria->with = 'question';
        $criteria->compare('t.authorId', $userId);
        return $criteria;
    }
    
    protected static function getQuestionsCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->scopes = ['category' => [self::getCategoryId()]];
        $criteria->select = 't.*';
        $criteria->join = 'LEFT OUTER JOIN ' . QaAnswer::model()->tableName() . ' answers ON answers.questionId = t.id';
        $criteria->addCondition('answers.authorId NOT IN (SELECT id FROM specialists__profiles)');
        $criteria->group = 't.id';
        $criteria->with = 'category';
        return $criteria;
    }

    protected static function getCategoryId()
    {
        return QaCategory::model()->find('title = :title', [':title' => 'Мой педиатр'])->id;
    }
}