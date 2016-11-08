<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * @author Sergey Gubarev
 */
class QaManager
{

    /**
     * Получить ответы к вопросу на сайте
     *
     * Для ответов специалистов, используется специальное условие с задержкой во времени публикации
     *
     * @param QaQuestion $question
     * @return static[]
     */
    public static function getAnswers(QaQuestion $question)
    {
        $timeCondition = null;

        if ($question->category->isPediatrician())
        {
            $time = time() - 60 * QaAnswer::MINUTES_AWAITING_PUBLISHED;

            $timeCondition = 'qa__answers.dtimeCreate >= ' . $time . ' AND ';
        }

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
                qa__answers.id NOT IN(
    			    SELECT
                        qa__answers.id
                      FROM
                        qa__answers
                      WHERE
                        $timeCondition
                        qa__answers.authorId IN(
                            SELECT
                                specialists__profiles.id
                            FROM
                                specialists__profiles
                        )
                )
        ";

        return QaAnswer::model()->findAllBySql($sql);
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
                qa__answers.id NOT IN(
    			    SELECT
                        qa__answers.id
                      FROM
                        qa__answers
                      WHERE
                        qa__answers.dtimeCreate >= $time
                        AND
                        qa__answers.authorId IN(
                            SELECT
                                specialists__profiles.id
                            FROM
                                specialists__profiles
                        )
                )
       ";

        return \Yii::app()->db->createCommand($sql)->queryColumn()[0];
    }

}