<?php
namespace site\frontend\modules\specialists\modules\pediatrician\helpers;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use Aws\CloudFront\Exception\Exception;

/**
 * @author Emil Vililyaev
 * @todo Пенести в виджеты
 */
class AnswersTree
{

    /**
     * @var array
     */
    private $_answers = [];

    /**
     * @var array
     */
    private $_rootAnswers = [];

    /**
     * @var CController
     */
    private $_controller;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * echo html content
     */
    public function render()
    {
        if (!is_array($this->_answers))
        {
            return;
        }

        echo $this->_renderTree();
    }

    /**
     * @param QaAnswer[] $arrAnswers
     * @throws Exception
     */
    public function init($arrAnswers)
    {
        if (!is_array($arrAnswers))
        {
            throw new Exception('$arrAnswers must by array');
        }

        $this->_controller  = \Yii::app()->getController();
        $this->_answers     = $arrAnswers;

        foreach ($arrAnswers as /*@var $answer QaAnswer */ $answer)
        {
            if (!($answer instanceof QaAnswer))
            {
                throw new Exception('$arrAnswers must by array of QaAnswer!');
            }


            if (is_null($answer->root_id))
            {
                $this->_rootAnswers[] = $answer;
            }
        }
    }

    /**
     * @return integer|NULL
     */
    public function getCurrentAnswerForSpecialist()
    {
        $additionalAnswers = [];
        $userId = \Yii::app()->user->getId();

        foreach ($this->_answers as /*@var $answer QaAnswer */ $answer)
        {
            if ($answer->isAnswerToAdditional() || $answer->authorId == $userId)
            {
                continue;
            }

            $additionalAnswers[$answer->dtimeCreate] = $answer;
        }

        if (empty($additionalAnswers))
        {
            return NULL;
        }

        $currentAnswer = $additionalAnswers[max(array_keys($additionalAnswers))];

        return is_null($currentAnswer) ? NULL : $currentAnswer;
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * @param QaAnswer $rootAnswer
     * @return \site\frontend\modules\som\modules\qa\models\QaAnswer[]
     */
    private function _getChild(QaAnswer $rootAnswer)
    {
        $matchedAnswers = [];

        foreach ($this->_answers as $answer)
        {
            if ($answer->root_id != $rootAnswer->id)
            {
                continue;
            }

            $matchedAnswers[] = $answer;
        }

        return $matchedAnswers;
    }

    /**
     * @return string
     */
    private function _renderTree()
    {
        $tree = '';

        foreach($this->_rootAnswers as $answer)
        {
            $rootView = $this->_controller->renderPartial('answerTemplates/rootAnswer', ['answer' => $answer], TRUE);
            $childView = '';

            $childAnswers = $this->_getChild($answer);

            if (!empty($childAnswers))
            {
                $childView = $this->_recursiveRenderChild($childAnswers);
            }

            $tree .= $this->_controller->renderPartial('answerTemplates/wrapers', ['rootAnswerContent' => $rootView,'childAnswerContent' => $childView], TRUE);
        }

        return $tree;
    }

    /**
     * @param QaAnswer $answer
     * @return string
     */
    private function _recursiveRenderChild($arrAnswer)
    {
        $outputBuffer = '';

        foreach ($arrAnswer as $answer)
        {
            $outputBuffer .= $this->_controller->renderPartial('answerTemplates/childAnswer', ['answer' => $answer], TRUE);
            $childAnswers = $this->_getChild($answer);

            if (!empty($childAnswers))
            {
                $outputBuffer .= $this->_recursiveRenderChild($childAnswers);
            }
        }

        return $outputBuffer;
    }

}