<?php
/**
 * @author Никита
 * @date 13/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaUserRating;

class QaUsersRatingManager
{
    const QUESTIONS_RATING_COEFFICIENT = 1;
    const ANSWERS_COUNT_COEFFICIENT = 1;
    const BEST_ANSWERS_COUNT_COEFFICIENT = 10;
    const INSERTS_PER_QUERY = 10000;

    public static function run()
    {
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            foreach (\Yii::app()->getModule('som')->getModule('qa')->periods as $type => $typeData) {
                self::runForPeriod($type, $typeData['duration']);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
        }
    }

    protected function runForPeriod($type, $period)
    {
        $questionsData = self::getQuestionsData($period);
        $answersData = self::getAnswersData($period);

        $rating = array();
        foreach ($questionsData as $value) {
            $userId = $value['authorId'];
            self::createRow($rating, $userId, $type);
            $rating[$userId]['questionsCount'] = $value['c'];
            $rating[$userId]['rating'] += $value['r'] * self::QUESTIONS_RATING_COEFFICIENT;
        }
        foreach ($answersData as $value) {
            $userId = $value['authorId'];
            self::createRow($rating, $userId, $type);
            $rating[$userId]['answersCount'] = $value['c'];
            $rating[$userId]['rating'] += $value['c'] * (($value['isBest']) ? self::BEST_ANSWERS_COUNT_COEFFICIENT : self::ANSWERS_COUNT_COEFFICIENT);
        }
        $rating = self::setPositions($rating);

        QaUserRating::model()->deleteAll('type = :type', array(':type' => $type));
        $nInserts = ceil(count($rating) / self::INSERTS_PER_QUERY);
        for ($i = 0; $i < $nInserts; $i++) {
            $toInsert = array_slice($rating, $i * self::INSERTS_PER_QUERY, self::INSERTS_PER_QUERY);
            \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand(QaUserRating::model()->tableName(), $toInsert)->execute();
        }
    }

    protected function setPositions($rating)
    {
        uasort($rating, function($a, $b) {
            if ($a['rating'] == $b['rating']) {
                return 0;
            }
            return ($a['rating'] > $b['rating']) ? -1 : 1;
        });

        $counter = 0;
        $last = null;
        foreach ($rating as $k => &$row) {
            if ($last !== $row['rating']) {
                $counter++;
            }
            $row['position'] = $counter;
            $last = $row['rating'];
        }

        return $rating;
    }

    protected function createRow(&$array, $userId, $type)
    {
        if (! isset($array[$userId])) {
            $array[$userId] = array(
                'userId' => $userId,
                'type' => $type,
                'questionsCount' => 0,
                'answersCount' => 0,
                'rating' => 0,
            );
        }
    }

    protected static function getQuestionsData($period)
    {
        $criteria = clone QaQuestion::model()->getDbCriteria();
        self::augmentCriteriaByPeriod($criteria, $period);
        $criteria->select = 'authorId, COUNT(*) c, SUM(rating) r';
        $criteria->group = 'authorId';
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaQuestion::model()->tableName(), $criteria);
        return $command->queryAll();
    }

    protected static function getAnswersData($period)
    {
        $criteria = clone QaAnswer::model()->getDbCriteria();
        self::augmentCriteriaByPeriod($criteria, $period);
        $criteria->select = 'authorId, isBest, COUNT(*) c';
        $criteria->group = 'authorId';
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria);
        return $command->queryAll();
    }

    protected static function getBestAnswers($period)
    {
        $criteria = clone QaAnswer::model()->getDbCriteria();
        self::augmentCriteriaByPeriod($criteria, $period);
        $criteria->addCondition('t.votesCount > 0');
        $criteria->group = 't.questionId';
        $criteria->order = 't.votesCount DESC';
        $criteria->index = 't.id';

        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria);
        $outerCommand = \Yii::app()->db->createCommand("SELECT authorId, COUNT(*) c FROM (" . $command->text . ") s GROUP BY authorId;");
        return $outerCommand->queryAll();
    }

    protected static function augmentCriteriaByPeriod(&$criteria, $period)
    {
        if ($period != 0) {
            $minDtimeCreate = time() - $period;
            $criteria->compare('dtimeCreate', '>' . $minDtimeCreate);
        }
    }
}