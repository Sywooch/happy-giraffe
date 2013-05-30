<?php
/**
 * Class ScoreInputFirstBlogRecord
 *
 * Начисление баллов пользователю за первую запись в личном блоге
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputFirstBlogRecord extends ScoreInput
{
    public $type = self::TYPE_FIRST_BLOG_RECORD;

    /**
     * @var ScoreInputFirstBlogRecord
     */
    private static $_instance;

    /**
     * @return ScoreInputFirstBlogRecord
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
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     */
    public function add($user_id)
    {
        $this->user_id = $user_id;
        $this->insert();
    }

    /**
     * Вычитание баллов
     *
     * @param $user_id int id пользователя
     */
    public function remove($user_id)
    {
        $this->user_id = $user_id;
        parent::remove();
    }
}