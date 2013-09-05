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
     * Клубы, которые показываем
     * @var CommunityClub[]
     */
    public $clubs;

    /**
     * @var bool
     */
    public $signup = false;

    public function init()
    {
        parent::init();

        $this->visible = ($this->user) ? $this->isMyProfile || !empty($this->user->clubSubscriptions) : true;
        if ($this->visible) {
            $this->data = $this->getUserClubsData();

            $this->viewFile = get_class($this) . $this->size . ($this->signup ? 'Signup' : '');
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
        if (empty($this->clubs))
            $this->clubs = CUserSubscriptions::getInstance($this->user->id)->getSubUserClubIds();

        $clubs = CommunityClub::model()->findAllByPk($this->clubs);
        foreach ($clubs as $club) {
                $data [] = array(
                    'id' => $club->id,
                    'title' => $club->title,
                    'have' => Yii::app()->user->isGuest ? false : CUserSubscriptions::getInstance($this->user->id)->subscribed($club->id),
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
