<?php
/**
 * Class ScoreInputContestPrize
 *
 * Начисление баллов пользователю за место в конкурсе
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputContestPrize extends ScoreInput
{
    /**
     * @var ScoreInputContestPrize
     */
    private static $_instance;
    public $contest_id;

    /**
     * @return ScoreInputContestPrize
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
     * @param $contest_id int id конкурса
     * @param $place int место
     */
    public function add($user_id, $contest_id, $place)
    {
        $this->user_id = $user_id;
        switch ($place) {
            case 1:
                $this->type = self::TYPE_CONTEST_WIN;
                break;
            case 2:
                $this->type = self::TYPE_CONTEST_2_PLACE;
                break;
            case 3:
                $this->type = self::TYPE_CONTEST_3_PLACE;
                break;
            case 4:
                $this->type = self::TYPE_CONTEST_4_PLACE;
                break;
            case 5:
                $this->type = self::TYPE_CONTEST_5_PLACE;
                break;
            default:
                $this->type = self::TYPE_CONTEST_ADDITIONAL_PRIZE;
        }

        $this->insert(array('contest_id' => $contest_id));
    }
}