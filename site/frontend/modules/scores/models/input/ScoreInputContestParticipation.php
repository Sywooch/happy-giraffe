<?php
/**
 * Class ScoreInputContestParticipation
 *
 * Начисление баллов пользователю за участие в конкурсе
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputContestParticipation extends ScoreInputEntity
{
    public $type = self::TYPE_CONTEST_PARTICIPATION;

    /**
     * @var ScoreInputContestParticipation
     */
    private static $_instance;

    /**
     * @return ScoreInputContestParticipation
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
     */
    public function add($user_id, $contest_id)
    {

    }
}