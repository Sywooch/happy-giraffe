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
     * Сколько клубов пропустить
     * @var int
     */
    public $offset = 0;
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
    /**
     * Клубы, которые показываем
     * @var CommunityClub[]
     */
    public $clubs;

    public function init()
    {
        parent::init();

        $this->visible = ($this->user) ? $this->isMyProfile || !empty($this->user->clubSubscriptions) : true;
        if ($this->visible) {
            $this->data = $this->getUserClubsData();

            $this->viewFile = get_class($this) . $this->size;
            Yii::app()->clientScript->registerPackage('ko_profile');
        }
    }

    /**
     * Возвращает информацию о сообществах
     * @return array
     */
    private function getUserClubsData()
    {
        $data = array();
        if (empty($this->clubs)){
            if ($this->userClubs)
                $this->clubs = UserClubSubscription::getSubUserClubs($this->user->id);
            else
                $this->clubs = UserClubSubscription::notSubscribedClubIds($this->user->id);
        }
        $clubs = CommunityClub::model()->findAllByPk($this->clubs);

        foreach ($clubs as $club) {
            $data [] = array(
                'id' => $club->id,
                'title' => $club->title,
                'have' => Yii::app()->user->isGuest ? false : UserClubSubscription::subscribed($this->user->id, $club->id),
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
            'offset' => $this->offset,
            'deleteClub' => $this->deleteClub,
        );
    }
}
