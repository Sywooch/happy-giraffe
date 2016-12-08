<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaQuestion;

abstract class BaseAnswerManager
{
    /**
     * @var null|QaQuestion
     */
    protected $question;
    
    /**
     * @param QaQuestion $question
     */
    public function __construct(QaQuestion $question)
    {
        $this->question = $question;
    }
    
    /**
     * @param $authorId
     * @param $content
     * @param $subject
     * @return mixed
     */
    abstract public function createAnswer($authorId, $content, $subject);
    
    /**
     * @return mixed
     */
    abstract public function getAnswers();
    
    /**
     * @return int
     */
    abstract public function getAnswersCount();
    
    /**
     * @param mixed $answer
     * @param \User $user
     * @return bool
     */
    abstract public function canAnswer($answer, \User $user);
}