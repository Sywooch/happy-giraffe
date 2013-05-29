<?php
/**
 * Class ScoreInputNewPhoto
 *
 * Начисление баллов пользователю за новое фото в фотоальбомах
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewPhoto extends ScoreInputMassive
{
    const WAIT_TIME = 3;

    public $type = self::TYPE_VIDEO;

    /**
     * @var ScoreInputNewPhoto
     */
    private static $_instance;

    /**
     * @return ScoreInputNewPhoto
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
     * @param $photo_id int id нового друга
     */
    public function add($user_id, $photo_id)
    {
        parent::add($user_id, $photo_id, self::WAIT_TIME * 3600);
    }

    /**
     * Вычитаем баллы
     *
     * @param int $user_id
     * @param int $photo_id
     */
    public function remove($user_id, $photo_id)
    {
        $this->user_id = (int)$user_id;
        parent::remove($photo_id);
    }
}