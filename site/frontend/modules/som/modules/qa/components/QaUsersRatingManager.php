<?php
/**
 * @author Никита
 * @date 13/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class QaUsersRatingManager
{
    public static function run()
    {

    }

//    protected function runForPeriod($period)
//    {
//        $ratings = array();
//        $questionsData = self::getQuestionsData($period);
//        $answersData = self::getAnswersData($period);
//
//
//    }

//    protected static function getQuestionsData($period)
//    {
//        $criteria = clone QaQuestion::model()->getDbCriteria();
//        if ($period != 0) {
//            $minDtimeCreate = time() - $period;
//            $criteria->compare('dtimeCreate', '>' . $minDtimeCreate);
//        }
//        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaQuestion::model()->tableName(), $criteria);
//        return $command->queryAll();
//    }
//
//    protected static function getAnswersData($period)
//    {
//        $criteria = clone QaAnswer::model()->getDbCriteria();
//        if ($period != 0) {
//            $minDtimeCreate = time() - $period;
//            $criteria->compare('dtimeCreate', '>' . $minDtimeCreate);
//        }
//        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria);
//        return $command->queryAll();
//    }
}