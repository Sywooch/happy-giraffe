<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class InterestsWidget extends UserCoreWidget
{
    public $interests = array();
    public $data = array(
        'interests' => array(),
        'categories' => array(),
    );

    public function init()
    {
        parent::init();
        Yii::import('site.common.models.interest.*');

        $this->interests = $this->user->interests;
        $this->visible = $this->isMyProfile || !empty($this->interests);

        if ($this->isMyProfile)
            $current_user_interests = $this->interests;
        elseif (!Yii::app()->user->isGuest)
            $current_user_interests = Yii::app()->user->getModel()->interests; else
            $current_user_interests = array();

        foreach ($this->interests as $interest) {
            $this->data['interests'][] = array(
                'id' => $interest->id,
                'title' => $interest->title,
                'category_id' => $interest->category_id,
                'have' => ($this->isMyProfile) ? true : (Yii::app()->user->isGuest ? false : $this->currentUserHas($current_user_interests, $interest->id)),
                'users' => $interest->getUsersData(),
                'count' => $interest->usersCount - 6,
            );
        }

        if ($this->isMyProfile) {
            $categories = InterestCategory::model()->with('interests')->findAll();
            foreach ($categories as $category) {
                $cat = array(
                    'id' => $category->id,
                    'title' => $category->title,
                );
                foreach ($category->interests as $interest)
                    $cat['interests'][] = array(
                        'id' => $interest->id,
                        'title' => $interest->title,
                    );
                $this->data['categories'][] = $cat;
            }
        }
    }

    /**
     * Имеет ли текущий пользователь этот интерес
     *
     * @param Interest[] $current_user_interests
     * @param int $interest_id
     * @return bool
     */
    private function currentUserHas($current_user_interests, $interest_id)
    {
        foreach ($current_user_interests as $current_user_interest)
            if ($current_user_interest->id == $interest_id)
                return true;

        return false;
    }
}
