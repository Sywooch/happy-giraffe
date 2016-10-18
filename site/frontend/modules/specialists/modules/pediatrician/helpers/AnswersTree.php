<?php
namespace site\frontend\modules\specialists\modules\pediatrician\helpers;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use Aws\CloudFront\Exception\Exception;

class AnswersTree
{

    private $_answers;

    private $_rootAnswers = [];

    private $_controller;

    public function render($arrAnswers)
    {
        if (!is_array($arrAnswers))
        {
            return;
        }

        $this->_init($arrAnswers);

        echo $this->_renderTree();
    }

    private function _init($arrAnswers)
    {
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

    private function _hasChild(QaAnswer $rootAnswer)
    {
        foreach ($this->_answers as $answer)
        {
            if ($answer->root_id != $rootAnswer->id)
            {
                continue;
            }

            return $answer;
        }

        return FALSE;
    }

    private function _renderTree()
    {
        $tree = '';

        foreach($this->_rootAnswers as $answer)
        {
            $rootView = $this->_controller->renderPartial('answerTemplates/rootAnswer', ['answer' => $answer], TRUE);
            $childView = '';

            $childAnswer = $this->_hasChild($answer);

            if ($childAnswer)
            {
                $childView = $this->_recursiveRenderChild($childAnswer);
            }

            $tree .= $this->_controller->renderPartial('answerTemplates/wrapers', ['rootAnswerContent' => $rootView,'childAnswerContent' => $childView], TRUE);
        }

        return $tree;
    }

    private function _recursiveRenderChild($answer, $outputBuffer = '')
    {
        $outputBuffer .= $this->_controller->renderPartial('answerTemplates/childAnswer', ['answer' => $answer], TRUE);
        $childAnswer = $this->_hasChild($answer);

        if ($childAnswer)
        {
//             var_dump('test');
            $this->_recursiveRenderChild($childAnswer, $outputBuffer);
        }

        return $outputBuffer;
    }

}