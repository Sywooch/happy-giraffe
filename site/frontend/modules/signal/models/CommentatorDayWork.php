<?php

/**
 * Работа комментатора за день, состоит из 2-х частей
 * 1. Выполнение плана за день
 * 2. Статистика комментаторов по премиям за день
 *
 * Сохраняем статистику для прошедших дней, чтобы каждый раз не вычислять ее
 *
 */
class CommentatorDayWork extends EMongoEmbeddedDocument
{
    /**
     * План не выполнен
     */
    const STATUS_FAILED = 0;
    /**
     * План выполнен
     */
    const STATUS_SUCCESS = 1;

    public $date;
    /**
     * Дата в формате секундах
     * @var int
     */
    public $created;
    /**
     * Количество пропусков за день
     * @var int
     */
    public $skip_count = 0;
    /**
     * Количество постов в блог за день
     * @var int
     */
    public $blog_posts = 0;
    /**
     * Количество постов в клуб за день
     * @var int
     */
    public $club_posts = 0;
    /**
     * Количество комментариев, засчитанных за день
     * @var int
     */
    public $comments = 0;
    /**
     * Статус выполнения плана: выполнен, не выполнен, перевыполнен
     * @var int
     */
    public $status = 0;

    /**
     * Статистика личных сообщений
     * 'out' => количество исходящих сообщений
     * 'in' => количество входящих сообщений
     * 'interlocutors_in' => количество написавших респондентов
     * 'interlocutors_out' => количество получивших от комментатора сообщения респондентов
     * @var array
     */
    public $im = array(
        'out' => 0,
        'in' => 0,
        'interlocutors_in' => 0,
        'interlocutors_out' => 0,
    );
    /**
     * Статистика посещения анкеты
     * 'main' => посещений профиля
     * 'blog' => количество посещений блога
     * 'photo' => количество посещений фотогалерей
     * 'visits' => количество просмотров всех разделов
     * 'visitors' => количество поситителей
     * @var array
     */
    public $visits = array(
        'main' => 0,
        'photo' => 0,
        'blog' => 0,
        'visitors' => 0,
        'visits' => 0,
    );

    /**
     * Статистика друзей
     * 'requests' => количество заявок
     * 'friends' => количество установленных дружеских связей
     * @var array
     */
    public $friends = array(
        'requests' => 0,
        'friends' => 0,
    );

    /**
     * Закрыт ли день для перерасчета данных статистики
     * @var int
     */
    public $closed = 0;

    /**
     * Пересчет статистики за день
     * @param $commentator CommentatorWork модель работы комментатора
     */
    public function calculateStats($commentator)
    {
        if (!$this->closed) {
            $this->calcImMessageStats($commentator->user_id);
            $this->calcFriendsStats($commentator->user_id);
            $this->visits = CommentatorHelper::visits($commentator->user_id, $this->date, $this->date);
            $this->checkStatus($commentator);

            if ($this->date != date("Y-m-d"))
                $this->closed = 1;

            $this->created = strtotime($this->date);

            //обновляем вычисленную статистику
            $criteria = new EMongoCriteria();
            $criteria->addCond('user_id', '==', $commentator->user_id);

            //находим номер рабочего дня в массиве дней
            $day_index = null;
            foreach ($commentator->days as $_index => $day)
                if ($day->date == $this->date)
                    $day_index = $_index;

            $modifier = new EMongoModifier();
            $modifier->addModifier('days.'.$day_index.'.friends.requests', 'set', $this->friends['requests']);
            $modifier->addModifier('days.'.$day_index.'.friends.friends', 'set', $this->friends['friends']);

            $modifier->addModifier('days.'.$day_index.'.visits.main', 'set', $this->visits['main']);
            $modifier->addModifier('days.'.$day_index.'.visits.photo', 'set', $this->visits['photo']);
            $modifier->addModifier('days.'.$day_index.'.visits.blog', 'set', $this->visits['blog']);
            $modifier->addModifier('days.'.$day_index.'.visits.visitors', 'set', $this->visits['visitors']);
            $modifier->addModifier('days.'.$day_index.'.visits.visits', 'set', $this->visits['visits']);

            $modifier->addModifier('days.'.$day_index.'.im.out', 'set', $this->im['out']);
            $modifier->addModifier('days.'.$day_index.'.im.in', 'set', $this->im['in']);
            $modifier->addModifier('days.'.$day_index.'.im.interlocutors_in', 'set', $this->im['interlocutors_in']);
            $modifier->addModifier('days.'.$day_index.'.im.interlocutors_out', 'set', $this->im['interlocutors_out']);

            $modifier->addModifier('days.'.$day_index.'.status', 'set', $this->status);
            $modifier->addModifier('days.'.$day_index.'.created', 'set', $this->created);
            $modifier->addModifier('days.'.$day_index.'.closed', 'set', $this->closed);

            CommentatorWork::model()->updateAll($modifier, $criteria);
        }
    }

    /**
     * Проверка выполнения
     * @param $section
     * @return CDbCriteria
     */
    public function checkPosts($section)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'updated >= :day_start AND updated <= :day_end AND status = ' . SeoTask::STATUS_CLOSED
            . ' AND sub_section = :section AND executor_id = :user_id';
        $criteria->params = array(
            ':day_start' => date("Y-m-d") . ' 00:00:00',
            ':day_end' => date("Y-m-d") . ' 23:59:59',
            ':section' => $section,
            ':user_id' => Yii::app()->user->id
        );

        return SeoTask::model()->count($criteria);
    }

    public function calcImMessageStats($commentator_id)
    {
        $this->im = CommentatorHelper::imStats($commentator_id, $this->date);
    }

    public function calcFriendsStats($commentator_id)
    {
        $this->friends = CommentatorHelper::friendStats($commentator_id, $this->date);
    }

    public function incSkips($commentator)
    {
        $this->skip_count++;
        $this->updateFields($commentator, array('skip_count'));
    }

    public function incComments($commentator)
    {
        $this->comments++;
        $this->updateFields($commentator, array('comments'));
    }

    public function updatePosts($commentator)
    {
        $this->updateFields($commentator, array('blog_posts', 'club_posts'));
    }

    public function updateFields($commentator, $fields){
        $criteria = new EMongoCriteria();
        $criteria->addCond('user_id', '==', $commentator->user_id);

        //находим номер рабочего дня в массиве дней
        $day_index = null;
        foreach ($commentator->days as $_index => $day)
            if ($day->date == $this->date)
                $day_index = $_index;

        $modifier = new EMongoModifier();
        foreach($fields as $field)
            $modifier->addModifier('days.'.$day_index.'.'.$field, 'set', $this->$field);

        CommentatorWork::model()->updateAll($modifier, $criteria);
    }

    /**
     * @param $commentator CommentatorWork
     */
    public function checkStatus($commentator)
    {
        if ($this->blog_posts >= $commentator->getBlogPostsLimit() &&
            $this->club_posts >= $commentator->getClubPostsLimit() &&
            $this->comments >= $commentator->getCommentsLimit()
        )
            $this->status = self::STATUS_SUCCESS;
    }
}
