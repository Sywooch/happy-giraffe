<?php
/**
 * @author Никита
 * @date 12/11/14
 */

namespace site\frontend\modules\family\models\viewData;


use site\frontend\modules\family\components\AgeHelper;
use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\family\models\PregnancyChild;

class PregnancyChildViewData extends FamilyMemberViewData
{
    public function getTitle()
    {
        $dictionary = $this->getDictionary();
        return $dictionary[$this->model->gender]['title'];
    }

    public function getAsString()
    {
        return $this->getTitle() . ' ' . AgeHelper::getPregnancyTermString($this->model->birthday);
    }

    public function getCssClass()
    {
        $dictionary = $this->getDictionary();
        return $dictionary[$this->model->gender]['cssClass'];
    }

    protected function getDictionary()
    {
        return array(
            FamilyMember::GENDER_MALE => array(
                'title' => 'Ждем мальчика',
                'cssClass' => 'boy-wait',
            ),
            FamilyMember::GENDER_FEMALE => array(
                'title' => 'Ждем девочку',
                'cssClass' => 'girl-wait',
            ),
            PregnancyChild::GENDER_TWINS => array(
                'title' => 'Ждем двойню',
                'cssClass' => 'baby-two',
            ),
            null => array(
                'title' => 'Ждем ребенка',
                'cssClass' => 'baby',
            ),
        );
    }
} 