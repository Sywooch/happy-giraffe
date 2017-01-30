<?php

namespace site\frontend\modules\specialists\modules\pediatrician\widgets;

use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * @author Emil Vililyaev
 */
class ListView extends \LiteListView
{

    /**
     * @var array
     */
    private $_personalQuetions = [];

    /**
     * Renders the data item list.
     */
    public function renderItems()
    {
        $this->_filteredData();

        if (!empty($this->_personalQuetions))
        {
            $this->_renderPersonalQuestions();
        }

        parent::renderItems();
    }

    /**
     * Отрисовка вопросов в которых есть персональный вопрос к врачу
     */
    private function _renderPersonalQuestions()
    {
        $questionsCount = count($this->_personalQuetions);
        $suffix = $questionsCount > 1 ? 'персональных вопроса' : 'персональный вопрос';
        echo '<div class="font__title-sn font__semi margin-b30">' . $questionsCount . ' ' . $suffix . '</div>';

        $currentData = $this->dataProvider->getData();

        $this->dataProvider->setData($this->_personalQuetions);
        parent::renderItems();
        $this->dataProvider->setData($currentData);

        echo \CHtml::openTag('hr', array('class' => 'pediator--hr')) . "\n";
    }

    /**
     * Фильтруем вопросы и извлекаем те в которых есть персональный вопрос
     */
    private function _filteredData()
    {
        $questionsList = $this->dataProvider->getData();
        $userId = \Yii::app()->user->id;

        foreach($questionsList as /*@var $question QaQuestion */$index => $question)
        {
            if ($question->hasAnswerForSpecialist($userId))
            {
                $this->_personalQuetions[] = $question;
                unset($questionsList[$index]);
            }
        }

        $this->dataProvider->setData($questionsList);
    }

}