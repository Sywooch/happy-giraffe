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
    public $type = self::TYPE_PHOTOS_ADDED;

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
        $this->user_id = $user_id;
        parent::add($photo_id);
    }

    /**
     * Вычитаем баллы
     *
     * @param int $user_id
     * @param int $photo_id
     */
    public function remove($user_id, $photo_id)
    {
        $this->user_id = $user_id;
        parent::remove($photo_id);
    }

    /**
     * Возвращает класс для иконки
     * @return string
     */
    public function getIcon()
    {
        return 'career-achievement-ico__photo';
    }
}