<?php

class ClubsWidget extends UserCoreWidget
{
    public $data = array();
    /**
     * Размер виджета, есть 2 размера, вьюхи лежат в разных файлах
     * @var string
     */
    public $size = 'Small';
    /**
     * Сколько максимум клубов выводим
     * @var int
     */
    public $limit = 100;
    /**
     * Удаляем ли клуб после того как пользователь отписался?
     * @var bool
     */
    public $deleteClub = false;
    /**
     * клубы на которые подписан пользователь или на которые он не подписан
     * @var bool
     */
    public $userClubs = true;

    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || !empty($this->user->communities);
        if ($this->visible) {
            $this->data = $this->getUserCommunitiesData();

            $this->viewFile = get_class($this) . $this->size;
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

    /**
     * Возвращает параметры для передачи в js-объект
     * @return array
     */
    public function getParams()
    {
        return array(
            'size' => $this->size,
            'limit' => $this->limit,
            'deleteClub' => $this->deleteClub,
        );
    }
}
