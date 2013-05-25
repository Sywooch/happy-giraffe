<?php
/**
 * Class ScoreInputNewPhoto
 *
 * Начисление баллов пользователю за новое фото в фотоальбомах
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewPhoto extends ScoreInputEntity
{
    public $type = self::TYPE_VIDEO;
    public $photo_id;

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

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $photo_id int id фото
     */
    public function add($user_id, $photo_id)
    {
        $this->user_id = $user_id;
        $this->insert(array('photo_id' => $photo_id));
    }
}