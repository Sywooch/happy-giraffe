<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaQuestion;
/**
 * @author Emil Vililyaev
 */
class QaQuestionsList
{

    /**
     * @var QaQuestion[]
     */
    private $_arrQuestions;

    /**
     * @param QaQuestion[] $arrQuestions
     */
    public function __construct($arrQuestions)
    {
        $this->_arrQuestions = $arrQuestions;
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return count($this->_arrQuestions);
    }

    /**
     * @param string $fieldName
     * @param integer $value
     * @return NULL|\site\frontend\modules\som\modules\qa\components\QaQuestionsList
     */
    public function sortedByField($fieldName, $value)
    {
        if (empty($this->_arrQuestions))
        {
            return;
        }

        $result = [];

        foreach ($this->_arrQuestions as $question)
        {
            if (isset($question->{$fieldName}) && $question->{$fieldName} == $value)
            {
                $result[] = $question;
            }
        }

        return new self($result);
    }

}