<?php
/**
 * Class ScoreInputRating
 *
 * Начисление баллов пользователю за попадание в список
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputRating extends ScoreInputEntity
{
    /**
     * @var ScoreInputRating
     */
    private static $_instance;

    /**
     * @return ScoreInputRating
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
     */
    public function add($user_id)
    {
        $this->user_id = $user_id;
        $this->insert();
    }
}