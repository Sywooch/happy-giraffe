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

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $award_id int id награды
     */
    public function add($user_id, $award_id)
    {
        $this->user_id = $user_id;
        parent::insert(array('award_id' => $award_id));
    }
}