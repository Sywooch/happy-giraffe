<?php
/**
 * Class ScoreInputNewFriend
 *
 * Начисление баллов пользователю за нового друга
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewFriend extends ScoreInputMassive
{
    public $type = self::TYPE_FRIEND_ADDED;

    /**
     * @var ScoreInputNewFriend
     */
    private static $_instance;

    /**
     * @return ScoreInputNewFriend
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
            self::$_instance = new self();

        return self::$_instance;
    }

    public function __construct()
    {
    }

    /**
     * Начисление баллов
     *
     * @param $user_id int id пользователя
     * @param $friend_id int id нового друга
     */
    public function add($user_id, $friend_id)
    {
        $this->user_id = $friend_id;
        parent::add($user_id);

        $this->user_id = $user_id;
        parent::add($friend_id);
    }

    /**
     * Вычитаем баллы
     *
     * @param int $user_id
     * @param int $friend_id
     */
    public function remove($user_id, $friend_id)
    {
        $this->user_id = (int)$user_id;
        parent::remove($friend_id);

        $this->user_id = (int)$friend_id;
        parent::remove($user_id);
    }

    /**
     * Возвращает класс для иконки
     * @return string
     */
    public function getIcon()
    {
        return 'career-achievement-ico__friends';
    }
}