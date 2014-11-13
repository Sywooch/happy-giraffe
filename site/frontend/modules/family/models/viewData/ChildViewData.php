<?php
/**
 * @author Никита
 * @date 12/11/14
 */

namespace site\frontend\modules\family\models\viewData;


use site\frontend\modules\family\components\AgeHelper;
use site\frontend\modules\family\models\FamilyMember;

class ChildViewData extends FamilyMemberViewData
{
    public function getTitle()
    {
        $dictionary = $this->getDictionary();
        return $dictionary[$this->model->gender]['title'];
    }

    public function getCssClass()
    {
        $dictionary = $this->getDictionary();
        return $dictionary[$this->model->gender]['cssClass'];
    }

    public function getAsString()
    {
        return $this->getTitle() . ' ' . $this->model->name . ' ' . AgeHelper::getChildAgeString($this->model->birthday);
    }

    protected function getDictionary()
    {
        return array(
            FamilyMember::GENDER_MALE => array(
                'title' => 'Сын',
                'cssClass' => 'boy-8',
            ),
            FamilyMember::GENDER_FEMALE => array(
                'title' => 'Дочь',
                'cssClass' => 'girl-8',
            ),
        );
    }
} 