<?php
/**
 * Class ScoreInput
 *
 * Начисление баллов пользователю за новый комментарий
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewComment extends ScoreInputEntity
{
    public $type = self::TYPE_COMMENT_ADDED;
    public $friends = array();

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

    /**
     * Начисление баллов
     *
     * @param $user_id int id пользователя
     * @param $comment_id int id нового комментария
     */
    public function add($user_id, $comment_id)
    {
        $this->user_id = $user_id;
        $this->insert(array('comment_id' => (int)$comment_id));
    }
}