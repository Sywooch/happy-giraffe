<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\tests\QaQuestionTest;

abstract class BaseAnswerManager
{
    /**
     * @var null|QaQuestion
     */
    private $question;
    
    /**
     * @param QaQuestion $question
     */
    public function __construct(QaQuestion $question)
    {
        $this->question = $question;
    }
    
    public function createAnswer($authorId, $content, ISubject $subject)
    {
        
    }
}