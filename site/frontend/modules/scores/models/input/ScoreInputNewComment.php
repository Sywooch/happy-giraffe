<?php
/**
 * Class ScoreInput
 *
 * Начисление баллов пользователю за новый комментарий
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewComment extends ScoreInputMassive
{
    const WAIT_TIME = 3;

    public $type = self::TYPE_COMMENT_ADDED;

    /**
     * @var ScoreInputNewComment
     */
    private static $_instance;

    /**
     * @return ScoreInputNewComment
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
     * @param $comment_id int id нового комментария
     */
    public function add($user_id, $comment_id)
    {
        parent::add($user_id, $comment_id, self::WAIT_TIME * 3600);
    }

    /**
     * Вычитаем баллы
     *
     * @param int $user_id
     * @param int $comment_id
     */
    public function remove($user_id, $comment_id)
    {
        $this->user_id = (int)$user_id;
        parent::remove($comment_id);
    }
}