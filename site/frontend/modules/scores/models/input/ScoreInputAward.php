<?php
/**
 * Class ScoreInputAward
 *
 * Начисление баллов пользователю за награду
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputAward extends ScoreInput
{
    public $type = self::TYPE_AWARD;
    public $award_id;

    /**
     * @var ScoreInputAward
     */
    private static $_instance;

    /**
     * @return ScoreInputAward
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
     * @param int $user_id id пользователя
     * @param ScoreUserAward $user_award награда
     */
    public function add($user_id, $user_award)
    {
        $this->user_id = $user_id;
        $this->scores = $user_award->award->scores;

        parent::insert(array('user_award_id' => $user_award->id));
    }
}