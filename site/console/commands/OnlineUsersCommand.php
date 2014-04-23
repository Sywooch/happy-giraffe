<?php

class OnlineUsersCommand extends CConsoleCommand
{
    /**
     * Сегодняшняя дата
     *
     * @property $currentDay
     */
    protected $currentDay;

    /**
     * Экземпляр класса Dklab_Realplexor
     *
     * @property Dklab_Realplexor $rpl
     */
    protected $rpl;

    /**
     * @property int $pos
     */
    protected $pos;

    /**
     * Инициализация
     *
     * Снимаем ограничение на занимаемую память, импортируем необходимые классы
     */
    public function init()
	{
		ini_set('memory_limit', -1);

		Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
		Yii::import('site.frontend.extensions.*');
		Yii::import('site.frontend.components.*');
		Yii::import('site.common.models.mongo.*');
		Yii::import('site.frontend.modules.scores.components.*');
		Yii::import('site.frontend.modules.scores.models.*');
		Yii::import('site.frontend.modules.scores.models.input.*');
		Yii::import('site.frontend.modules.onlineManager.widgets.OnlineManagerWidget');

        parent::init();
	}

    /**
     * Синхронизирует значения столбца online в таблице users с актуальным состояним на сайте
     */
    protected function sync()
    {
        // Выставляем всем пользователям оффлайн
        Yii::app()->db->createCommand()->update('users', array('online' => '0'));

        // Выставлем онлайн тем, кто сейчас онлайн
        $list = $this->rpl->cmdOnline(UserCache::CHANNEL_PREFIX);
        print_r($list);

        // Запрашиваем фейковое событие, именно с него начнем обработку
        $fakeEvent = $this->rpl->cmdWatch(0, UserCache::CHANNEL_PREFIX);
        print_r($fakeEvent);
        $this->pos = $fakeEvent[0]['pos'] - 1;

        foreach ($list as $channel)
        {
            $user = UserCache::getUserByCache($channel);
            if ($user !== null)
            {
                $user->online();
            }
        }
    }

    /**
     * Подготовка
     *
     * Выполняется один раз при старте команды
     */
    protected function prepare()
    {
        // Записываем экземпляр класса в свойство Dklab_Realplexor
        $this->rpl = Yii::app()->comet;

        // Устанавливаем текущую дату (необходимо для достижений)
        $this->currentDay = date("Y-m-d");

        // Синхронизируем БД
        $this->sync();

        echo "Подготовка завершена\n";
    }

    /**
     * Обработка конкретного события onOff
     */
    protected function handleEvent($event)
    {
        print_r($event);
        $user = UserCache::getUserByCache($event['id']);
        if ($user !== null) {
            if ($event['event'] == 'online') {
                $user->online();
                echo 'Пользователь #' . $user->id . ' снова в сети!' . "\n";
            } else {
                $user->offline();
                echo 'Пользователь #' . $user->id . ' покидает нас :(' . "\n";
            }
        }
        $this->pos = $event['pos'];
    }

    /**
     * Вызов команды
     */
    public function actionIndex()
    {
        $this->prepare();

        while (true)
        {
            // Начисление достижений
			$this->checkScoresForNewDay();

            // Выберем все события
            echo "Watching with pos=" . $this->pos . "\n";
            $events = $this->rpl->cmdWatch($this->pos, UserCache::CHANNEL_PREFIX);

            // Обработаем события
            foreach ($events as $event) {
                $this->handleEvent($event);
            }

            // Ждем
            sleep(10);
        }
    }

    public function actionTest($pos = 0)
    {
        $events = Yii::app()->comet->cmdWatch($this->pos, UserCache::CHANNEL_PREFIX);
        print_r($events);
    }

    public function actionCache($userId)
    {
        echo UserCache::GetUserCache($userId);
    }

	/**
	 * Начисление достижений
	 */
	protected function checkScoresForNewDay()
	{
		if ($this->currentDay != date("Y-m-d") && date("i") >= 15)
		{
			$list = $this->rpl->cmdOnline();

			foreach ($list as $user)
			{
				$user = $this->getUserByCache($user);
				if (!empty($user))
				{
					Scoring::visit($user->id);
				}
			}

			$this->currentDay = date("Y-m-d");
		}
	}

    /**
     * Финал битвы экстрасенсов 2014 будет посвящен анализу этого метода
     * http://hydra-media.cursecdn.com/dota2.gamepedia.com/2/29/Mystic_Staff_icon.png?version=a13d77c58e457102a665ec49d9853685
     */
    protected function mysticStaff()
    {
        // Мистика начало
        $users = User::model()->findAll(array('select' => 'id', 'condition' => 'online=1'));
        foreach ($users as $user)
        {
            Yii::app()->cache->delete('User_' . $user->id);
        }
        // Мистика конец
    }
}

