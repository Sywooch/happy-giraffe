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

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function add($user_id, $entity)
    {
        parent::add($user_id, $entity);
    }

    /**
     * Вычитание баллов
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function remove($user_id, $entity){
        parent::remove($user_id, $entity);
    }
}