<?php
/**
 * @author Никита
 * @date 12/11/14
 */

namespace site\frontend\modules\family\models\viewData;


use site\frontend\modules\family\models\FamilyMember;

class PlanningChildViewData extends FamilyMemberViewData
{
    public function getTitle()
    {
        switch ($this->model->gender) {
            case FamilyMember::GENDER_FEMALE:
                return 'Планируем девочку';
            case FamilyMember::GENDER_MALE:
                return 'Планируем мальчика';
            default:
                return 'Планируем ребенка';
        }
    }

    public function getAsString()
    {
        return $this->getTitle();
    }

    public function getCssClass()
    {
        return 'baby-plan';
    }
} 