<?php

namespace site\frontend\modules\iframe\components;

use site\frontend\modules\iframe\models\QaQuestion;

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