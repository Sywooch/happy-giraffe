<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * @author Sergey Gubarev
 * @deprecated {{@see BaseAnswerManager}}
 */
class QaManager
{

    /**
     * Получить ответы к вопросу на сайте
     *
     * Для ответов специалистов, используется специальное условие с задержкой во времени публикации
     *
     * @param QaQuestion $question
     * @return QaAnswer[]
     */
    public static function getAnswers(QaQuestion $question)
    {
        $timeCondition = null;

        if ($question->category->isPediatrician()) {
            $time = time() - 60 * QaAnswer::MINUTES_AWAITING_PUBLISHED;

            $timeCondition = 'qa__answers.dtimeCreate >= ' . $time . ' AND ';
        }

        $sql = <<<SQL
          SELECT * FROM qa__answers
            WHERE
            qa__answers.questionId = {$question->id}
              AND
            qa__answers.isRemoved = 0
              AND
            qa__answers.isPublished = 1
SQL;

        /*
        $sql = "
            SELECT
                *
            FROM
                qa__answers
            WHERE
                qa__answers.questionId = $question->id
                AND
                qa__answers.isRemoved = 0
                AND
                qa__answers.isPublished = 1
        ";
        */

        $answers = QaAnswer::model()->findAllBySql($sql);

        return $answers;
    }

    /**
     * Получить кол-во ответов к вопросу с учетом ответов от специлистов (с условием задержки их публикации на сайте)
     *
     * @param   integer $questionId ID вопроса
     * @return  string              Кол-во ответов
     */
    public static function getAnswersCountPediatorQuestion($questionId)
    {
        $time = time() - 60 * QaAnswer::MINUTES_AWAITING_PUBLISHED;

        $sql = <<<SQL
          SELECT COUNT(1) FROM qa__answers
            WHERE
            qa__answers.questionId = $questionId
              AND
            qa__answers.isRemoved = 0
              AND
            qa__answers.isPublished = 1
SQL;

        /*
       $sql = "
            SELECT
                COUNT(qa__answers.id)
            FROM
                qa__answers
            WHERE
                qa__answers.questionId = $questionId
                AND
                qa__answers.isRemoved = 0
                AND
                qa__answers.isPublished = 1
       ";
*/
        return \Yii::app()->db->createCommand($sql)->queryColumn()[0];
    }

}