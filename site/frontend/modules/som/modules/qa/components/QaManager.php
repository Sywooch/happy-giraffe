<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaQuestionEditing;

/**
 * @author Sergey Gubarev
 */
class QaManager
{

    /**
     * Получить ID comet-канала для вопроса
     *
     * @param $questionId ID вопроса
     * @return string
     */
    public static function getQuestionChannelId($questionId)
    {
        return QaQuestion::COMET_CHANNEL_ID_PREFIX . $questionId;
    }

    /**
     * Получить ID comet-канала для редактируемого вопроса
     *
     * @param $questionId ID вопроса
     * @return string
     */
    public static function getEditedQuestionChannelId($questionId)
    {
        return self::getQuestionChannelId($questionId) . QaQuestion::COMET_CHANNEL_ID_EDITED_PREFIX;
    }

    /**
     * Получить вопрос
     *
     * @param integer $questionId ID вопроса
     * @return \CActiveRecord|null
     */
    public static function getQuestion($questionId)
    {
        return QaQuestion::model()->findByPk($questionId);
    }

    /**
     * Находится ли вопрос под редактированием
     *
     * @param integer $questionId ID вопроса
     * @return bool
     */
    public static function isQuestionEditing($questionId)
    {
        $findObject = QaQuestionEditing::model()->findByAttributes(['questionId' => $questionId]);

        return is_null($findObject) ? false : true;
    }

    /**
     * Удалить объект вопроса их коллекции редактируемых в Mongo
     *
     * @param integer $questionId ID вопроса
     * @return bool
     */
    public static function deleteQuestionObjectFromCollection($questionId)
    {
        $findObject = QaQuestionEditing::model()->find([
            'questionId' => $questionId
        ]);

        return $findObject ? $findObject->delete() : false;
    }

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
    /*public static function getCountAnswersByUser($userId)
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
    }*/

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

    /**
     * @param QaQuestion $question
     * @param integer $answerId
     * @return boolean
     */
    public function canCreateAnswer(QaQuestion $question, $answerId = NULL)
    {
        /*@var $user \WebUser */
        $user = \Yii::app()->user;

        if ($user->isGuest)
        {
            return FALSE;
        }

        $isSpecialist = $user->getModel()->isSpecialist;

        /*@var $answer QaAnswer */
        $answer = QaAnswer::model()->findByPk($answerId);

        //если коментирует специалист
        if ($isSpecialist)
        {
            return $this->_canCreateAnswerSpecialist($question, $user, $answer);
        }

        //если коментирует автор вопроса
        if ($question->authorId == $user->id)
        {
            return $this->_canCreateAnswerAuthor($user, $answer);
        }

        //если коментирует другой пользователь
        if ($question->authorId != $user->id && !$isSpecialist)
        {
            return $this->_canCreateAnswerUser($question, $user, $answer);
        }

        return FALSE;
    }

    /**
     * @param QaQuestion $question
     * @param \WebUser $user
     * @param QaAnswer|NULL $answer
     * @return boolean
     */
    private function _canCreateAnswerUser(QaQuestion $question, \WebUser $user, $answer = NULL)
    {
        /*@var $answer QaAnswer */
        if (is_null($answer)) //если не дискусия
        {
            return $question->authorId != $user->id;
        }

        $dialog = $answer->ancestors()->findAll();

        if (empty($dialog) && $answer->isLeaf())
        {
            /*@var $rootItem QaAnswer */
            $rootItem = $answer;
        }
        else
        {
            $rootItem = $dialog[0];
        }


        return $rootItem->authorId == $user->id;
    }

    /**
     * @param \WebUser $user
     * @param QaAnswer|NULL $answer
     * @return boolean
     */
    private function _canCreateAnswerAuthor(\WebUser $user, $answer = NULL)
    {
        /*@var $answer QaAnswer */
        if (is_null($answer)) //если не дискусия
        {
            return FALSE;
        }

        $answerAuthor = $answer->author;


        return ($answerAuthor->id != $user->id && !$answerAuthor->isSpecialist) || ($answerAuthor->isSpecialist && !$answer->isAnswerToAdditional());
    }

    /**
     * @param QaQuestion $question
     * @param \WebUser $user
     * @param QaAnswer|NULL $answer
     * @return boolean
     */
    private function _canCreateAnswerSpecialist(QaQuestion $question, \WebUser $user, $answer = NULL)
    {
        /*@var $answer QaAnswer */

        $dialog = $question->getSpecialistDialog($user->id);

        if (is_null($answer)) //если не дискусия
        {
            return is_null($dialog);
        }

        $answerAuthor = $answer->author;
        $ancestors    = $answer->ancestors()->findAll();

        /*@var $rootItem QaAnswer */
        $rootItem = $ancestors[0];

        if (empty($ancestors))
        {
            return FALSE;
        }

        return $rootItem->authorId == $user->id && $answer->isAdditional();
    }

}