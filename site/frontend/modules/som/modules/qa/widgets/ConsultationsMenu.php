<?php
/**
 * @author Никита
 * @date 12/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets;


use site\frontend\modules\som\modules\qa\models\QaConsultation;

class ConsultationsMenu extends SidebarMenu
{
    public function init()
    {
        $this->items = array_map(function(QaConsultation $consultation) {
            return array(
                'label' => $consultation->title . '<span class="questions-categories_count">' . $consultation->questionsCount . '</span>',
                'url' => array('/som/qa/consultation/index', 'consultationId' => $consultation->id),
                'linkOptions' => array('class' => 'questions-categories_link'),
            );
        }, $this->getConsultations());
        parent::init();
    }

    protected function getConsultations()
    {
        return QaConsultation::model()->with('questionsCount')->findAll();
    }
}