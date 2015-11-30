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
        $consultations = $this->getConsultations();
        $this->items[] = array_map(function($consultation) {
            $this->getItem($consultation->title, $consultation->questionsCount, array('/som/qa/consultation/index/', 'consultationId' => $consultation->id));
        }, $consultations);
        parent::init();
    }

    /**
     * @return \site\frontend\modules\som\modules\qa\models\QaConsultation[]
     */
    protected function getConsultations()
    {
        return QaConsultation::model()->with('questionsCount')->findAll();
    }
}