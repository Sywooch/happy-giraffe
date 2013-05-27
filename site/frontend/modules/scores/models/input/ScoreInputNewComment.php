<?php
/**
 * Class ScoreInput
 *
 * Начисление баллов пользователю за новый комментарий
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewComment extends ScoreInput
{
    const WAIT_TIME = 3;

    public $type = self::TYPE_COMMENT_ADDED;
    public $comments = array();

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
        $exist = $this->exist();
        if (empty($exist))
            $this->insert(array('comment_id' => (int)$comment_id), time() + self::WAIT_TIME * 3600);
        else
            $this->update($exist, $comment_id);
    }

    protected function exist()
    {
        return $this->getCollection()->findOne(array(
            'type' => (int)$this->type,
            'user_id' => (int)$this->user_id,
            'show_time' => array('$lt' => time()),
        ));
    }

    protected function update($exist, $comment_id)
    {
        $this->getCollection()->update(
            array('_id' => $exist['_id']),
            array(
                '$push' => array('comments' => (int)$comment_id),
                '$inc' => array('scores' => $this->getScores())
            )
        );
    }

    public function remove($comment_id)
    {

    }
}