<?php

namespace site\frontend\modules\specialists\modules\pediatrician\components;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaRating;

/**
 * @author Никита
 * @date 16/08/16
 */
class QaManager
{
    const SKIPS_TABLE = 'specialists__pediatrician_skips';

    public static function getQuestionsDp($userId, $filterTagId = null)
    {
        $model = QaQuestion::model()
            ->orderDesc()
            ->apiWith('user');
        if(!empty($filterTagId)){
            $model = $model->byTag($filterTagId);
        }
        return new \CActiveDataProvider($model, [
            'criteria' => self::getQuestionsCriteria($userId),
        ]);
    }

    public static function getQuestionsCount($userId)
    {
        return QaQuestion::model()->count(self::getQuestionsCriteria($userId));
    }

    public static function getAnswersDp($userId = null, $onlyPublished = FALSE)
    {
        return new \CActiveDataProvider(QaAnswer::model()->orderDesc()->apiWith('user'), [
            'criteria' => self::getAnswersCriteria($userId, $onlyPublished),
        ]);
    }

    public static function skip($userId, $questionId)
    {
        return \Yii::app()->db->createCommand()->insert(self::SKIPS_TABLE, [
            'userId' => $userId,
            'questionId' => $questionId,
        ]) > 0;
    }

    /**
     * Получить кол-во ответов и "спасибо" по юзеру
     *
     * @param $userId ID юзера
     * @return array|null
     */
    public static function getAnswerCountAndVotes($userId)
    {
        $rating = QaRating::model()
                    ->byCategory(QaCategory::PEDIATRICIAN_ID)
                    ->byUser($userId)
                    ->find()
                ;

        return !is_null($rating) ? $rating->toJSON() : null;
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

    public static function getAnswersCriteria($userId = null, $onlyPublished = FALSE)
    {
        $criteria = new \CDbCriteria();
        $criteria->scopes = ['category' => [self::getCategoryId()], 'checkQuestionExiststance'];
        $criteria->with = 'question';
        $criteria->addCondition('t.authorId IN (SELECT id FROM specialists__profiles)');

        if ($userId)
        {
             $criteria->compare('t.authorId', $userId);
        }

        if (is_null($userId) || $onlyPublished)
        {
            $criteria->addCondition('t.isPublished=' . QaAnswer::PUBLISHED);
        }

        return $criteria;
    }

    public static function getQuestionsCriteriaOld($userId)
    {
        $criteria = new \CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'LEFT OUTER JOIN ' . QaAnswer::model()->tableName() . ' answers FORCE INDEX FOR JOIN(`questionId_isRemoved`) ON answers.questionId = t.id AND answers.isRemoved = 0';
        $criteria->group = 't.id';
        $criteria->scopes = ['category' => [self::getCategoryId()]];
        $criteria->with = 'category';
        $criteria->addCondition('t.id NOT IN (SELECT questionId FROM ' . self::SKIPS_TABLE . ' WHERE userId = :userId)');
        $criteria->addCondition('(answers.id IS NULL) OR (t.id NOT IN(SELECT a1.questionId FROM qa__answers a1
            LEFT JOIN qa__answers a2 FORCE INDEX FOR JOIN(`root_id_isRemoved`) ON a2.root_id = a1.id AND a2.isRemoved=0
            LEFT JOIN qa__answers a3 FORCE INDEX FOR JOIN(`root_id_isRemoved`) ON a3.root_id = a2.id AND a3.isRemoved=0
            WHERE
            (a1.authorId IN (SELECT specialists__profiles.id FROM specialists__profiles)
                AND (a3.authorId IN (SELECT specialists__profiles.id FROM specialists__profiles) OR (a3.authorId IS NULL AND a2.authorId IS NULL))
            ) OR (
    			(a1.authorId != :userId )
    			AND a1.authorId IN (SELECT specialists__profiles.id FROM specialists__profiles)
    			AND a2.authorId NOT IN (SELECT specialists__profiles.id FROM specialists__profiles)
    			AND a3.authorId IS NULL
			)
            ))');
        $criteria->order = 't.id IN (SELECT a1.questionId FROM qa__answers a1
            LEFT JOIN qa__answers a2 ON a2.root_id = a1.id
            LEFT JOIN qa__answers a3 ON a3.root_id = a2.id
            WHERE a1.authorId = :userId AND a2.authorId NOT IN (SELECT specialists__profiles.id FROM specialists__profiles) AND a3.authorId IS NULL) DESC';
        $criteria->params[':userId'] = $userId;
        return $criteria;
    }

    public static function getQuestionsCriteria($userId)
    {
        $criteria = new \CDbCriteria();
        $criteria->select = 't.*';
        $criteria->group = 't.id';
        $criteria->scopes = ['category' => [self::getCategoryId()]];
        $criteria->with = 'category';
        $criteria->join = '
        LEFT OUTER JOIN  ' . QaAnswer::model()->tableName() . ' as answers ON (answers.questionId = t.id)
        LEFT JOIN ' . QaAnswer::model()->tableName() . ' answers2 ON (answers2.root_id = answers.id AND answers2.isRemoved = 0)
        LEFT JOIN ' . QaAnswer::model()->tableName() . ' answers3 ON (answers3.root_id = answers2.id AND answers3.isRemoved = 0)
        ';
        $criteria->addCondition('t.id NOT IN (SELECT questionId FROM ' . self::SKIPS_TABLE . ' WHERE userId = :userId)');
        $criteria->addCondition('
        answers.authorId = :userId AND
        answers2.authorId  IS NOT NULL AND
        answers3.id IS NULL AND
        answers.root_id IS NULL OR
        answers.id IS NULL OR
        t.id NOT IN (SELECT questionId FROM qa__answers WHERE authorId IN (SELECT specialists__profiles.id FROM specialists__profiles))
        ');
        $criteria->order = 't.id IN (SELECT a1.questionId FROM qa__answers a1
            LEFT JOIN qa__answers a2 FORCE INDEX FOR JOIN(`root_id_isRemoved`) ON a2.root_id = a1.id AND a2.isRemoved=0
            LEFT JOIN qa__answers a3 FORCE INDEX FOR JOIN(`root_id_isRemoved`) ON a3.root_id = a2.id AND a3.isRemoved=0
            WHERE a1.authorId = :userId AND a2.authorId NOT IN (SELECT specialists__profiles.id FROM specialists__profiles) AND a3.authorId IS NULL) DESC,
            t.dtimeCreate >= (SELECT r1.dtimeCreate
            FROM qa__questions AS r1
            JOIN (SELECT (RAND() * (SELECT MAX(id) FROM qa__questions
            	WHERE
            	qa__questions.categoryId = 124
            	AND qa__questions.isRemoved=0
            )) AS id) AS r2
            WHERE
            r1.id >= r2.id
            AND r1.isRemoved=0
            ORDER BY r1.id ASC
            LIMIT 1) ASC';
        $criteria->params[':userId'] = $userId;
        return $criteria;
    }

    protected static function getCategoryId()
    {
        return QaCategory::PEDIATRICIAN_ID;
    }

    public static function getQuestionChannelId($questionId)
    {
        return QaQuestion::COMET_CHANNEL_ID_SPECIALIST_PREFIX . $questionId;
    }

}
