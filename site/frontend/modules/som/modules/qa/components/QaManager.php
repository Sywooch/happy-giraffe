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
        $sql = <<<SQL
          SELECT * FROM qa__answers
            WHERE
            qa__answers.questionId = {$question->id}
              AND
            qa__answers.isRemoved = 0
              AND
            qa__answers.isPublished = 1
SQL;

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
        $sql = <<<SQL
          SELECT COUNT(1) FROM qa__answers
            WHERE
            qa__answers.questionId = $questionId
              AND
            qa__answers.isRemoved = 0
              AND
            qa__answers.isPublished = 1
SQL;

        return \Yii::app()->db->createCommand($sql)->queryColumn()[0];
    }

    /**
     * @param QaQuestion $question
     * @param integer $answerId
     * @return boolean
     */
    public static function canCreateAnswer(QaQuestion $question, $answerId = NULL)
    {
        /*@var $user \WebUser */
        $user = \Yii::app()->user;

        if ($user->isGuest)
        {
            return FALSE;
        }

        if ($user->getModel()->isSpecialist)
        {
            return $question->checkCustomAccessByAnswered($user->id);
        }

        /*@var $answer QaAnswer */
        $answer = QaAnswer::model()->findByPk($answerId);

        if (is_object($answer) && $question->id != $answer->questionId)
        {
            return FALSE;
        }

        if ($question->authorId == $user->id)
        {
            if (is_null($answer))
            {
                return FALSE;
            } elseif (!$answer->authorIsSpecialist())
            {
                return $answer->authorId != $user->id;
            }
        }

        if (is_null($answer) || $answer->authorIsSpecialist())
        {
            return $question->checkCustomAccessByAnswered($user->id);
        }

        $answersList = new QaObjectList($answer->ancestors()->findAll());
        $userAnswers = $answersList->sortedByField('authorId', $user->id);

        return !$userAnswers->isEmpty();

    }

}