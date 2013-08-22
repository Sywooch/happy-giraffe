<?php

class ClubsWidget extends UserCoreWidget
{
    public $data = array();
    public $size = 'Small';
    public $userClubs = true;

    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || !empty($this->user->communities);
        if ($this->visible){
            $this->data = $this->getUserCommunitiesData();

            $this->viewFile = get_class($this).$this->size;
            Yii::app()->clientScript->registerPackage('ko_profile');
        }
    }

    /**
     * Возвращает информацию о сообществах
     * @return array
     */
    private function getUserCommunitiesData()
    {
        $data = array();
        if ($this->userClubs)
            $communities = UserCommunitySubscription::getSubUserCommunities($this->user->id);
        else
            $communities = UserCommunitySubscription::notSubscribedClubIds($this->user->id);
        $communities = Community::model()->findAllByPk($communities);

        foreach ($communities as $community) {
            $data [] = array(
                'id' => $community->id,
                'title' => $community->title,
                'have' => ($this->isMyProfile && $this->userClubs) ? true : ((Yii::app()->user->isGuest) ? false : UserCommunitySubscription::subscribed($this->user->id, $community->id)),
            );
        }
        return $data;
    }
}
