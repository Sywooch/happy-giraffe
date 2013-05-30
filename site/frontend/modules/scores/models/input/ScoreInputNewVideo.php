<?php
/**
 * Class ScoreInputNewVideo
 *
 * Начисление баллов пользователю за видео
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewVideo extends ScoreInputEntity
{
    public $type = self::TYPE_VIDEO;

    /**
     * @var ScoreInputNewVideo
     */
    private static $_instance;

    /**
     * @return ScoreInputNewVideo
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