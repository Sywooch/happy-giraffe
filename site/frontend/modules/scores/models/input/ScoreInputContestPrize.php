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
            default:
                $this->type = self::TYPE_CONTEST_5_PLACE;
        }

        $this->insert(array('contest_id' => $contest_id));
    }

    /**
     * Возвращает класс для иконки
     * @return string
     */
    public function getIcon()
    {
        return '';
    }

    public function descriptionClass()
    {
        return 'career-achievement__lavender';
    }

    public function getContestLink()
    {
        $contest = Contest::model()->findByPk($this->contest_id);
        return CHtml::link($contest->title, $contest->getUrl());
    }

    public function getImage()
    {
        return '<img src="/images/contest/contest-career-place' . $this->getPlace() . '-' . $this->contest_id . '.png" alt="">';
    }

    public function getPlace()
    {
        switch ($this->type) {
            case self::TYPE_CONTEST_WIN:
                return 1;
            case self::TYPE_CONTEST_2_PLACE:
                return 2;
            case self::TYPE_CONTEST_3_PLACE:
                return 3;
            case self::TYPE_CONTEST_4_PLACE:
                return 4;
            case self::TYPE_CONTEST_5_PLACE:
                return 5;
        }
    }
}