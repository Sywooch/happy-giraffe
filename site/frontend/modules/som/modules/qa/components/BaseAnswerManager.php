<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * Класс, отвечающий на связь Question -> Answers
 */
abstract class BaseAnswerManager
{
    /**
     * @param $authorId
     * @param $content
     * @param $subject
     * @return mixed
     */
    abstract public function createAnswer($authorId, $content, $subject);

    /**
     * @param $answerId
     * @return mixed
     */
    abstract public function getAnswer($answerId);

    /**
     * @param QaQuestion $question
     * @return mixed
     */
    abstract public function getAnswers(QaQuestion $question);
    
    /**
     * @param QaQuestion $question
     * @return int
     */
    abstract public function getAnswersCount(QaQuestion $question);
    
    /**
     * @param mixed $answer
     * @param \User $user
     * @return bool
     */
    abstract public function canAnswer($answer, \User $user);
}