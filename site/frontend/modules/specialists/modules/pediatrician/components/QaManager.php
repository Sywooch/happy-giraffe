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
    const SKIPS_TABLE = 'specialists__pediatrician_skips';

    public static function getQuestionsDp($userId)
    {
        return new \CActiveDataProvider(QaQuestion::model()->orderDesc()->apiWith('user'), [
            'criteria' => self::getQuestionsCriteria($userId),
        ]);
    }

    public static function getQuestionsCount($userId)
    {
        return QaQuestion::model()->count(self::getQuestionsCriteria($userId));
    }

    public static function getAnswersDp($userId = null)
    {
        return new \CActiveDataProvider(QaAnswer::model()->orderDesc()->apiWith('user'), [
            'criteria' => self::getAnswersCriteria($userId),
        ]);
    }

    public static function skip($userId, $questionId)
    {
        return \Yii::app()->db->createCommand()->insert(self::SKIPS_TABLE, [
            'userId' => $userId,
            'questionId' => $questionId,
        ]) > 0;
    }

    public static function getAnswerCountAndVotes($userId)
    {
         return \Yii::app()->db->createCommand()
            ->select('COUNT(*) AS count, SUM(votesCount) AS sumVotes')
            ->from(QaAnswer::model()->tableName())
            ->where('authorId=' . $userId)
            ->andWhere('isRemoved=0')
            ->queryRow()
        ;
    }

    /**
     * @param $questionId
     * @param $userId
     * @return QaQuestion|null
     */
    public static function getNextQuestion($questionId, $userId)
    {
        $criteria = self::getQuestionsCriteria($userId);
        $criteria->scopes[] = 'previous';
        return QaQuestion::model()->find($criteria);
    }

    public static function getAnswersCriteria($userId = null)
    {
        $criteria = new \CDbCriteria();
        $criteria->scopes = ['category' => [self::getCategoryId()], 'checkQuestionExiststance'];
        $criteria->with = 'question';
        $criteria->addCondition('t.authorId IN (SELECT id FROM specialists__profiles)');
        
        if ($userId) {
             $criteria->compare('t.authorId', $userId);
        }
        else {
            $time = time() - 60 * QaAnswer::MINUTES_AWAITING_PUBLISHED;
            
            $criteria->addCondition('t.dtimeCreate <= '. $time);
        }
        
        return $criteria;
    }

    /**
     * Emil Vililyaev: пока не используется
     * @param integer $userID
     * @return \CDbCriteria
     */
    public static function getPersonalQuestions($userID)
    {
        $criteria = new \CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'LEFT JOIN qa__answers AS t2 ON t2.root_id = t.id AND t2.isRemoved = 0';
        $criteria->join .= ' LEFT JOIN qa__answers AS t3 ON t3.root_id = t2.id AND t3.isRemoved = 0';
        $criteria->addCondition('t2.id IS NOT NULL');
        $criteria->addCondition('t.authorId = :userId');
        $criteria->addCondition('t3.id IS NULL AND t.isRemoved = 0');
        $criteria->params[':userId'] = $userID;

        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand('qa__answers', $criteria)->queryAll();

        return $criteria;
    }

    public static function getQuestionsCriteria($userId)
    {
        $criteria = new \CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'LEFT OUTER JOIN ' . QaAnswer::model()->tableName() . ' answers ON answers.questionId = t.id AND answers.isRemoved = 0';
        $criteria->group = 't.id';
        $criteria->scopes = ['category' => [self::getCategoryId()]];
        $criteria->with = 'category';
        $criteria->addCondition('t.id NOT IN (SELECT questionId FROM ' . self::SKIPS_TABLE . ' WHERE userId = :userId)');
        $criteria->addCondition('(answers.id IS NULL) OR (t.id NOT IN(SELECT a1.questionId FROM qa__answers a1
            LEFT JOIN qa__answers a2 ON a2.root_id = a1.id
            LEFT JOIN qa__answers a3 ON a3.root_id = a2.id
            WHERE ((a1.authorId IN (SELECT specialists__profiles.id FROM specialists__profiles)
            AND (a3.authorId IN (SELECT specialists__profiles.id FROM specialists__profiles)
            OR (a3.authorId IS NULL AND a2.authorId IS NULL))))))');
        $criteria->params[':userId'] = $userId;
        return $criteria;
    }

    protected static function getCategoryId()
    {
        return QaCategory::PEDIATRICIAN_ID;
    }
}