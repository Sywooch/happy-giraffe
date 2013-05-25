<?php
/**
 * Class ScoreInputFirstBlogRecord
 *
 * Начисление баллов пользователю за первую запись в личном блоге
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputFirstBlogRecord extends ScoreInputEntity
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

    /**
     * Добавление баллов за запись в личном блоге
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function add($user_id, $entity)
    {
        parent::add($user_id, $entity);
    }
}