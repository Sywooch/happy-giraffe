<?php
/**
 * @author Никита
 * @date 02/12/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\my;


class MyPersonalWidget extends PersonalWidget
{
    public $htmlOptions = array(
        'class' => 'popup-widget_heading_ul',
    );
    public $itemCssClass = 'popup-widget_heading_li';

    protected function generateItems()
    {
        return array(
            array(
                'label' => 'Мои вопросы ' . $this->getQuestionsCount(),
                'url' => $this->questionsUrl,
            ),
            array(
                'label' => 'Мои ответы ' . $this->getAnswersCount(),
                'url' => $this->answersUrl,
            ),
        );
    }
}