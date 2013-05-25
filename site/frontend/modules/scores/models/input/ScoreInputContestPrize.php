<?php
/**
 * Class ScoreInputContestPrize
 *
 * Начисление баллов пользователю за место в конкурсе
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputContestPrize extends ScoreInputEntity
{
    /**
     * @var ScoreInputContestPrize
     */
    private static $_instance;

    /**
     * @return ScoreInputContestPrize
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
     * @param $contest_id int id конкурса
     * @param $place int место
     */
    public function add($user_id, $contest_id, $place)
    {

    }
}