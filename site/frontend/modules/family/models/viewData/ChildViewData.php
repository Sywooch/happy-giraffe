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
    private $ageMap = array(
        18 => '19',
        12 => '14',
        6 => '8',
        3 => '5',
        1 => '3',
    );

    public function getTitle()
    {
        switch ($this->model->gender) {
            case FamilyMember::GENDER_MALE:
                return 'Сын';
            case FamilyMember::GENDER_FEMALE:
                return 'Дочь';
            default:
                return 'Ребенок';
        }
    }

    public function getCssClass()
    {
        if ($this->model->gender === null) {
            return 'boy-small';
        }

        $genderSign = ($this->model->gender == FamilyMember::GENDER_MALE) ? 'boy' : 'girl';
        $ageSign = $this->getAgeSign();
        return $genderSign . '-' . $ageSign;
    }

    public function getAsString()
    {
        $result = $this->getTitle();
        if (! empty($this->model->name)) {
            $result .= ' ' . $this->model->name;
        }
        if ($this->model->birthday !== null) {
            $result .= ' ' . AgeHelper::getChildAgeString($this->model->birthday);
        }
        return $result;
    }

    protected function getAgeSign()
    {
        if ($this->model->birthday === null) {
            return $this->ageMap[6];
        }

        $age = AgeHelper::getAge($this->model->birthday);
        foreach ($this->ageMap as $threshold => $string) {
            if ($age >= $threshold) {
                return $string;
            }
        }
        return 'small';
    }
} 