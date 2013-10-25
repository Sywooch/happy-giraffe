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
    /**
     * @var int id конкурса
     */
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
     * Начисление баллов за победу/место в последнем конкурсе
     */
    public function checkLastContest()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'id desc';
        $last_contest = Contest::model()->find($criteria);

        $this->checkContest($last_contest->id);
    }

    /**
     * Начисление баллов за победу/место в конкурсе
     *
     * @param int $contest_id
     */
    public function checkContest($contest_id)
    {
        $winners = ContestWinner::model()->with('work')->findAll('contest_id=' . $contest_id);
        foreach ($winners as $winner)
            $this->checkPrize($winner);
    }

    /**
     * @param ContestWinner $winner
     */
    public function checkPrize($winner)
    {
        $model = $this->getCollection()->findOne(array(
            'type' => $this->getTypeByPlace($winner->place),
            'user_id' => (int)$winner->work->user_id,
            'contest_id' => (int)$winner->work->contest_id,
        ));
        if (empty($model))
            $this->add($winner);
    }

    /**
     * Добавление баллов
     *
     * @param $winner ContestWinner приз
     */
    public function add($winner)
    {
        $this->user_id = $winner->work->user_id;
        $this->type = $this->getTypeByPlace($winner->place);

        $this->insert(array('contest_id' => (int)$winner->work->contest_id));
    }

    /**
     * Возвращает тип уведомления для места в конкурсе
     *
     * @param int $place место в конкурсе
     * @return int тип уведомления
     */
    private function getTypeByPlace($place)
    {
        switch ($place) {
            case 1:
                $type = self::TYPE_CONTEST_WIN;
                break;
            case 2:
                $type = self::TYPE_CONTEST_2_PLACE;
                break;
            case 3:
                $type = self::TYPE_CONTEST_3_PLACE;
                break;
            case 4:
                $type = self::TYPE_CONTEST_4_PLACE;
                break;
            default:
                $type = self::TYPE_CONTEST_5_PLACE;
        }

        return $type;
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