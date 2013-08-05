<?php

class ClubsWidget extends UserCoreWidget
{
    public $data = array();

    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || !empty($this->user->communities);
        if ($this->visible)
            $this->data = $this->getUserCommunitiesData();
    }

    /**
     * Возвращает информацию о сообществах
     * @return array
     */
    private function getUserCommunitiesData()
    {
        $data = array();
        foreach ($this->user->communities as $community) {
            $data [] = array(
                'id' => $community->id,
                'title' => $community->title,
                'have' => ($this->isMyProfile) ? true : ((Yii::app()->user->isGuest) ? false : Yii::app()->user->getModel()->isInCommunity($community->id)),
            );
        }
        return $data;
    }
}
