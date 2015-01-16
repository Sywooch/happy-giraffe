<?php

namespace site\frontend\modules\family\models\viewData;
use site\frontend\modules\family\models\Adult;
use site\frontend\modules\family\models\FamilyMember;

/**
 * @author Никита
 * @date 12/11/14
 */

class AdultViewData extends FamilyMemberViewData
{
    protected $dictionary = array(
        Adult::STATUS_FRIENDS => array(
            Adult::GENDER_MALE => array(
                'title' => 'Друг',
                'cssClass' => 'boy-friend',
            ),
            Adult::GENDER_FEMALE => array(
                'title' => 'Подруга',
                'cssClass' => 'girl-friend',
            ),
        ),
        Adult::STATUS_ENGAGED => array(
            Adult::GENDER_MALE => array(
                'title' => 'Жених',
                'cssClass' => 'fiance',
            ),
            Adult::GENDER_FEMALE => array(
                'title' => 'Невеста',
                'cssClass' => 'bride',
            ),
        ),
        Adult::STATUS_MARRIED => array(
            Adult::GENDER_MALE => array(
                'title' => 'Муж',
                'cssClass' => 'husband',
            ),
            Adult::GENDER_FEMALE => array(
                'title' => 'Жена',
                'cssClass' => 'wife',
            ),
        ),
    );

    public function getTitle()
    {
        return ($this->model->userId !== null) ? 'Я' : $this->dictionary[$this->model->relationshipStatus][$this->model->gender]['title'];
    }

    public function getAsString()
    {
        return $this->getTitle() . ' ' . $this->model->name;
    }

    public function getCssClass()
    {
        if ($this->model->relationshipStatus !== null) {
            return $this->dictionary[$this->model->relationshipStatus][$this->model->gender]['cssClass'];
        }
        return ($this->model->gender == 0) ? 'girl-friend' : 'boy-friend';
    }
} 