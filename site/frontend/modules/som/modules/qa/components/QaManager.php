<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
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
     * Получить кол-во всех ответов по сервису "Педиатр" у пользователя
     *
     * @param integer $userId ID пользователя
     * @return integer
     */
    public static function getCountAnswersByUser($userId)
    {
        return QaAnswer::model()
                    ->with('question')
                    ->count(
                        'question.categoryId = :categoryId AND t.authorId = :authorId AND t.isRemoved = :isRemoved AND t.isPublished = :isPublished',
                        [
                            ':categoryId'   => QaCategory::PEDIATRICIAN_ID,
                            ':authorId'     => $userId,
                            ':isRemoved'    => QaAnswer::NOT_REMOVED,
                            ':isPublished'  => QaAnswer::PUBLISHED
                        ]
                    )
                ;
    }

    /**
     * Получить дерево ответов к вопросу
     *
     * @param integer $questionId ID вопроса
     * @return array
     */
    public static function getAnswersTreeByQuestion($questionId)
    {
        $rootAnswers = QaAnswer::model()
                                    ->roots()
                                    ->orderDesc()
                                    ->findAll(
                                        'isRemoved = :isRemoved AND isPublished = :isPublished AND questionId = :questionId',
                                        [
                                            ':isRemoved'    => QaAnswer::NOT_REMOVED,
                                            ':isPublished'  => QaAnswer::PUBLISHED,
                                            ':questionId'   => $questionId
                                        ]
                                    )
                        ;

        $rootAnswersList = array_map(
                                function($answerObj)
                                {
                                    return $answerObj->toJSON();
                                },
                                $rootAnswers
                            );

        foreach ($rootAnswersList as &$rootAnswerData)
        {
            $rootAnswerData['answers'] = [];

            $childAnswers = self::getChildAnswers($rootAnswerData['id']);

            $countChildAnswers = count($childAnswers);

            $rootAnswerData['countChildAnswers'] = $countChildAnswers;

            if ($countChildAnswers)
            {
                // $rootAnswerData['answers'] = AnswerManagementData::process($childAnswers);
                foreach ($childAnswers as $childAnswer)
                {
                    $rootAnswerData['answers'][] = $childAnswer->toJSON();
                }
            }
        }

        return $rootAnswersList;
    }

    public static function getChildAnswers($id)
    {
        return QaAnswer::model()
                    ->descendantsOf($id)
                    ->findAll()
                ;
    }

    public static function getCountChildAnswers($id)
    {
        return count(self::getChildAnswers($id));
    }

}