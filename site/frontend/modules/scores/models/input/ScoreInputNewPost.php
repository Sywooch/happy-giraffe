<?php
/**
 * Class ScoreInputNewPost
 *
 * Начисление баллов пользователю за запись
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewPost extends ScoreInputEntity
{
    public $type = self::TYPE_POST_ADDED;

    /**
     * @var ScoreInputNewPost
     */
    private static $_instance;

    /**
     * @return ScoreInputNewPost
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
}