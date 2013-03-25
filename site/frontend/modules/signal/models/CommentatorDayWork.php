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
    /**
     * План перевыполнен
     */
    const STATUS_EXCEEDED = 2;

    public $date;
    /**
     * В какое время начал работать
     * @var int
     */
    public $created;
    /**
     * Количество пропусков за день
     * @var int
     */
    public $skip_count;
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
     * 'interlocutors' => количество респондентов
     * @var array
     */
    public $im = array(
        'out' => 0,
        'in' => 0,
        'interlocutors' => 0,
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
        'blog' => 0,
        'photo' => 0,
        'visits' => 0,
        'visitors' => 0,
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
     * Пересчет статистика за день
     * @param $commentator_id int id комментатора
     */
    public function calculateStats($commentator_id)
    {
        $this->im = CommentatorHelper::imStats($commentator_id, $this->date);
        $this->friends = CommentatorHelper::friendStats($commentator_id, $this->date);
        $this->visits = CommentatorHelper::visits($commentator_id, $this->date);
    }

    /**
     * @param $commentator CommentatorWork
     */
    public function checkStatus($commentator)
    {
        if ($this->blog_posts == $commentator->getBlogPostsLimit() &&
            $this->club_posts == $commentator->getClubPostsLimit() &&
            $this->comments == $commentator->getCommentsLimit()
        )
            $this->status = self::STATUS_SUCCESS;
        elseif ($this->blog_posts >= $commentator->getBlogPostsLimit() &&
            $this->club_posts >= $commentator->getClubPostsLimit() &&
            $this->comments >= $commentator->getCommentsLimit()
        )
            $this->status = self::STATUS_EXCEEDED;
    }

    public function getStatusView()
    {
        if ($this->status == self::STATUS_SUCCESS)
            return '<td class="task-done">Выполнен</td>';
        if ($this->status == self::STATUS_EXCEEDED)
            return '<td class="task-overdone">Перевыполнен</td>';
        return '<td class="task-not-done">Не выполнен</td>';
    }
}
