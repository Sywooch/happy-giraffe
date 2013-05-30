<?php
/**
 * Class ScoreInputVisit
 *
 * Начисление баллов пользователю за посещение сайта
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputVisit extends ScoreInputEntity
{
    public $type = self::TYPE_VISIT;

    /**
     * @var ScoreInputVisit
     */
    private static $_instance;

    /**
     * @return ScoreInputVisit
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
}