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

    /**
     * Возвращает класс для иконки
     * @return string
     */
    public function getIcon()
    {
        return 'career-achievement-ico__blog';
    }
}