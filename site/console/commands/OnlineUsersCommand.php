<?php

class OnlineUsersCommand extends CConsoleCommand
{
    const CHECK_PERIODICITY = 300;

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

        // Записываем экземпляр класса в свойство Dklab_Realplexor
        $this->rpl = Yii::app()->comet;

        parent::init();
	}

    /**
     * Синхронизирует значения столбца online в таблице users с актуальным состояним на сайте
     */
    protected function sync()
    {
        // Выставляем всем пользователям оффлайн
        Yii::app()->db->createCommand()->update('users', array('online' => '0'));

        // Запрашиваем фейковое событие, именно с него начнем обработку
        $fakeEvent = $this->rpl->cmdWatch(0, UserCache::CHANNEL_PREFIX);
        /**
         * Вычитание единицы связано с магией реалплексора - при watch с 0 позиции он возвращает ФЕЙКОВОЕ событие с
         * неким id, но следующее РЕАЛЬНОЕ событие будет иметь не следующий порядковый номер после фейкового, как
         * ожидается, а такой же. Соответственно, чтобы его не пропустить, нужно вычесть единицу.
         */
        $this->pos = $fakeEvent[0]['pos'] - 1;

        // Выставлем онлайн тем, кто сейчас онлайн
        $list = $this->rpl->cmdOnline(UserCache::CHANNEL_PREFIX);
        foreach ($list as $channel)
        {
            $user = UserCache::getUserByCache($channel);
            if ($user !== null)
            {
                OnlineManager::online($user);
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
        $user = UserCache::getUserByCache($event['id']);
        if ($user !== null) {
            if ($event['event'] == 'online') {
                OnlineManager::online($user);
                echo 'Пользователь #' . $user->id . ' снова в сети!' . "\n";
            } else {
                OnlineManager::offline($user);
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

        $i = 0;
        while ($i++)
        {
            $check = ($i % self::CHECK_PERIODICITY) == 0;

            // Начисление достижений
			$this->checkScoresForNewDay();

            // Если на этом шаге надо делать проверку - сразу же получим список онлайн-каналов
            if ($check) {
                $online = $this->rpl->cmdOnline(UserCache::CHANNEL_PREFIX);
            }

            // Выберем все события
            $events = $this->rpl->cmdWatch($this->pos, UserCache::CHANNEL_PREFIX);

            // Обработаем события
            foreach ($events as $event) {
                $this->handleEvent($event);
            }

            // Проверим
            if ($check) {
                $this->check($online);
            }

            // Ждем
            sleep(1);
        }
    }

    public function actionCheck()
    {
        $online = $this->rpl->cmdOnline(UserCache::CHANNEL_PREFIX);
        $this->check($online);
    }

    /**
     * Проверяет, соответствует ли состояние таблицы в БД данным плексора
     */
    protected function check($online)
    {
        $offlineByMistake = Yii::app()->db->createCommand()
            ->select('users.id')
            ->from('users')
            ->join('im__user_cache', 'im__user_cache.user_id = users.id')
            ->where(array('AND', 'users.online = 0', array('IN', 'im__user_cache.cache', $online)))->queryColumn();

        $onlineByMistake = Yii::app()->db->createCommand()
            ->select('users.id')
            ->from('users')
            ->join('im__user_cache', 'im__user_cache.user_id = users.id')
            ->where(array('AND', 'users.online = 1', array('NOT IN', 'im__user_cache.cache', $online)))->queryColumn();

        $str = '';
        if (! empty ($offlineByMistake)) {
            $str .= 'Оффлайн по ошибке: ' . implode(', ', $offlineByMistake);
        }
        if (! empty ($onlineByMistake)) {
            $str .= 'Оффлайн по ошибке: ' . implode(', ', $onlineByMistake);
        }
        echo $str;
    }



	/**
	 * Начисление достижений
	 */
	protected function checkScoresForNewDay()
	{
		if ($this->currentDay != date("Y-m-d") && date("i") >= 15)
		{
			$list = $this->rpl->cmdOnline(UserCache::CHANNEL_PREFIX);

			foreach ($list as $user)
			{
				$user = UserCache::GetUserCache($user);
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

