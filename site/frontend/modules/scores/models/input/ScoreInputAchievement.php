<?php
/**
 * Class ScoreInputAchievement
 *
 * Начисление баллов пользователю за новое фото в фотоальбомах
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputAchievement extends ScoreInputEntity
{
    public $type = self::TYPE_VIDEO;

    /**
     * @var ScoreInputAchievement
     */
    private static $_instance;

    /**
     * @return ScoreInputAchievement
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
     * @param $entity CActiveRecord модель
     */
    public function add($user_id, $entity)
    {
        parent::add($user_id, $entity);
    }
}