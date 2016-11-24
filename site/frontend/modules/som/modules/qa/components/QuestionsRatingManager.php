<?php
namespace site\frontend\modules\som\modules\qa\components;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * @author Никита
 * @date 11/11/15
 */

class QuestionsRatingManager extends \CComponent
{
    const VIEWS_DIVIDER = 10;
    const ANSWERS_DIVIDER = 1;
    const TIME_DIVIDER = 1000000;

    public static function updateAll()
    {
        $dp = new \CActiveDataProvider('site\frontend\modules\som\modules\qa\models\QaQuestion');
        $iterator = new \CDataProviderIterator($dp);
        foreach ($iterator as $q) {
            self::updateSingle($q);
        }
    }

    public static function updateSingle(QaQuestion $question)
    {
        $rating = self::byModel($question);
        if ($question->rating != $rating) {
            $question->saveAttributes(array('rating' => $rating));
        }
    }

    public static function byModel(QaQuestion $question)
    {
        $viewsCount = \Yii::app()->getModule('analytics')->visitsManager->getVisits($question->url);
        $answersCount = $question->answersCount;
        $dtimeCreate = $question->dtimeCreate;
        return self::byParameters($viewsCount, $answersCount, $dtimeCreate);
    }

    public static function byParameters($viewsCount, $answersCount, $dtimeCreate)
    {
        $viewsMember = $viewsCount / self::VIEWS_DIVIDER;
        $answersMember = log10($answersCount) / self::ANSWERS_DIVIDER;
        $timeMember = (time() - $dtimeCreate) / self::TIME_DIVIDER;

        return ($viewsMember + $answersMember) / $timeMember;
    }
}