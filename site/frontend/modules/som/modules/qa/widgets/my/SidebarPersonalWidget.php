<?php
/**
 * @author Никита
 * @date 27/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\my;



class SidebarPersonalWidget extends PersonalWidget
{
    public $htmlOptions = array(
        'class' => 'personal-links_ul',
    );
    public $itemCssClass = 'personal-links_li';
    public $encodeLabel = false;

    protected function generateItems()
    {
        return array(
            array(
                'label' => 'Мои вопросы <span class="personal-links_count">' . $this->getQuestionsCount() . '</span>',
                'url' => $this->questionsUrl,
                'linkOptions' => array('class' => 'personal-links_link'),
            ),
            array(
                'label' => 'Мои ответы <span class="personal-links_count">' . $this->getAnswersCount() . '</span>',
                'url' => $this->answersUrl,
                'linkOptions' => array('class' => 'personal-links_link'),
            ),
        );
    }
}