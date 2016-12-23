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
     * Получить дерево ответов к вопросу
     *
     * @param integer $questionId ID вопроса
     * @return array|null
     */
    public static function getAnswersByQuestion($questionId)
    {
        $sql = 'SELECT 
                    * 
                    FROM ' . QaAnswer::model()->tableName() . '
                    WHERE 
                        isRemoved = ' . QaAnswer::NOT_REMOVED . '
                        AND
                        isPublished = ' . QaAnswer::PUBLISHED . '
                        AND
                        questionId = ' . $questionId . '
                        AND
                        root_id IS NULL
                    ORDER BY id DESC
              ';

        $rootAnswers = QaAnswer::model()->findAllBySql($sql);

        if (! count($rootAnswers))
        {
            return null;
        }

        $answersData = [];

        foreach ($rootAnswers as $answerModel)
        {
            $answersData[] = $answerModel->toJSON();
        }

        return $answersData;
    }

}