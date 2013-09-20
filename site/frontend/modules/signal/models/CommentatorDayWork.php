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
            $this->addAllPosts($commentator->user_id);
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
            $modifier->addModifier('days.' . $day_index . '.friends.requests', 'set', $this->friends['requests']);
            $modifier->addModifier('days.' . $day_index . '.friends.friends', 'set', $this->friends['friends']);

            $modifier->addModifier('days.' . $day_index . '.im.out', 'set', $this->im['out']);
            $modifier->addModifier('days.' . $day_index . '.im.in', 'set', $this->im['in']);
            $modifier->addModifier('days.' . $day_index . '.im.interlocutors_in', 'set', $this->im['interlocutors_in']);
            $modifier->addModifier('days.' . $day_index . '.im.interlocutors_out', 'set', $this->im['interlocutors_out']);

            $modifier->addModifier('days.' . $day_index . '.status', 'set', $this->status);
            $modifier->addModifier('days.' . $day_index . '.created', 'set', $this->created);
            $modifier->addModifier('days.' . $day_index . '.closed', 'set', $this->closed);

            $modifier->addModifier('days.' . $day_index . '.blog_posts', 'set', (int)$this->blog_posts);
            $modifier->addModifier('days.' . $day_index . '.club_posts', 'set', (int)$this->club_posts);

            CommentatorWork::model()->updateAll($modifier, $criteria);
        }
    }

    /**
     * Обновление кол-ва постов, написанных за день
     * @param CommentatorWork $commentator
     */
    public function updatePostsCount($commentator)
    {
        $this->addAllPosts($commentator->user_id);
        $this->checkStatus($commentator);

        //обновляем вычисленную статистику
        $criteria = new EMongoCriteria();
        $criteria->addCond('user_id', '==', $commentator->user_id);

        //находим номер рабочего дня в массиве дней
        $day_index = null;
        foreach ($commentator->days as $_index => $day)
            if ($day->date == $this->date)
                $day_index = $_index;

        $modifier = new EMongoModifier();
        $modifier->addModifier('days.' . $day_index . '.status', 'set', $this->status);
        $modifier->addModifier('days.' . $day_index . '.blog_posts', 'set', (int)$this->blog_posts);
        $modifier->addModifier('days.' . $day_index . '.club_posts', 'set', (int)$this->club_posts);

        CommentatorWork::model()->updateAll($modifier, $criteria);
    }

    /**
     * Вычислить кол-во выполненных заданий за текущий день по написанию статей в блог/клуб
     *
     * @param $section int блог/клуб
     * @param $user_id int id комментатора
     * @return int кол-во выполненных заданий
     */
    public function checkPosts($section, $user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'updated >= :day_start AND updated <= :day_end AND status = ' . SeoTask::STATUS_CLOSED
            . ' AND sub_section = :section AND executor_id = :user_id';
        $criteria->params = array(
            ':day_start' => $this->date . ' 00:00:00',
            ':day_end' => $this->date . ' 23:59:59',
            ':section' => $section,
            ':user_id' => $user_id
        );

        return SeoTask::model()->count($criteria);
    }

    /**
     * Вычислить кол-во выполненных заданий за текущий день по написанию статей в блог/клуб
     *
     * @param $user_id int id комментатора
     * @return int кол-во выполненных заданий
     */
    public function addAllPosts($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= :day_start AND created <= :day_end AND author_id=:author_id AND rubric.user_id=:author_id AND type_id NOT IN (5,6) AND removed=0';
        $criteria->with = array('rubric');
        $criteria->params = array(
            ':day_start' => $this->date . ' 00:00:00',
            ':day_end' => $this->date . ' 23:59:59',
            ':author_id' => $user_id
        );
        $this->blog_posts = CommunityContent::model()->count($criteria);

        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= :day_start AND created <= :day_end AND author_id=:author_id AND rubric.user_id IS NULL AND type_id NOT IN (5,6) AND removed=0';
        $criteria->with = array('rubric');
        $criteria->params = array(
            ':day_start' => $this->date . ' 00:00:00',
            ':day_end' => $this->date . ' 23:59:59',
            ':author_id' => $user_id
        );
        $this->club_posts = CommunityContent::model()->count($criteria);

        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= :day_start AND created <= :day_end AND author_id=:author_id AND removed=0';
        $criteria->params = array(
            ':day_start' => $this->date . ' 00:00:00',
            ':day_end' => $this->date . ' 23:59:59',
            ':author_id' => $user_id
        );
        $this->club_posts += CookRecipe::model()->count($criteria);
    }

    /**
     * Пересчитать статистику по сообщениям
     * @param $commentator_id int id комментатора
     */
    public function calcImMessageStats($commentator_id)
    {
        $this->im = CommentatorHelper::imStats($commentator_id, $this->date);
    }

    /**
     * Пересчитать статистику по друзьям
     * @param $commentator_id int id комментатора
     */
    public function calcFriendsStats($commentator_id)
    {
        $this->friends = CommentatorHelper::friendStats($commentator_id, $this->date);
    }

    /**
     * Увеличить на 1 количество пропусков
     * @param $commentator CommentatorWork работа комментатора
     */
    public function incSkips($commentator)
    {
        $this->skip_count++;
        $this->updateFields($commentator, array('skip_count'));
    }

    /**
     * Увеличить на 1 количество комментариев
     * @param $commentator CommentatorWork работа комментатора
     */
    public function incComments($commentator)
    {
        $this->comments++;
        $this->checkStatus($commentator);
        $this->updateFields($commentator, array('comments', 'status'));
    }

    /**
     * Обновить кол-во постов в монго-базе для текущего рабочего дня
     * @param $commentator CommentatorWork работа комментатора
     */
    public function updatePosts($commentator)
    {
        $this->updateFields($commentator, array('blog_posts', 'club_posts', 'status'));
    }

    /**
     * Обновить отдельное поле в монго-базе для текущего рабочего дня
     * @param $commentator CommentatorWork работа комментатора
     * @param $fields string поле для обновления
     */
    public function updateFields($commentator, $fields)
    {
        $criteria = new EMongoCriteria();
        $criteria->addCond('user_id', '==', $commentator->user_id);

        //находим номер рабочего дня в массиве дней
        $day_index = null;
        foreach ($commentator->days as $_index => $day)
            if ($day->date == $this->date)
                $day_index = $_index;

        $modifier = new EMongoModifier();
        foreach ($fields as $field)
            $modifier->addModifier('days.' . $day_index . '.' . $field, 'set', $this->$field);

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

    /**
     * Обновить информацию о статусе
     * @param $commentator
     */
    public function updateStatus($commentator)
    {
        $this->checkStatus($commentator);
        $this->updateFields($commentator, array('status'));
    }
}
