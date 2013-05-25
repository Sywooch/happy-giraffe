<?php
/**
 * Class ScoreInputNewFriend
 *
 * Начисление баллов пользователю за нового друга
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewFriend extends ScoreInput
{
    public $type = self::TYPE_FRIEND_ADDED;
    public $friends = array();

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

    /**
     * Начисление баллов пользователю за нового друга
     *
     * @param $user_id int id пользователя
     * @param $friend_id int id нового друга
     */
    public function add($user_id, $friend_id)
    {
        $this->user_id = $user_id;
        $this->insert();
    }
}