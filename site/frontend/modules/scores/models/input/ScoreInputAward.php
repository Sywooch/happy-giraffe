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
    /**
     * @var int
     */
    public $award_id;
    /**
     * @var ScoreAward
     */
    private $_award;

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

        parent::insert(array('award_id' => $user_award->award_id));
    }

    /**
     * Возращает название уведомления
     * @return string
     */
    public function getTitle()
    {
        return $this->getAward()->title;
    }

    /**
     * Возращает описание уведомления
     * @return string
     */
    public function getDescription()
    {
        return explode("\n", $this->getAward()->description);
    }

    /**
     * Возвращает иконку
     * @return string
     */
    public function getImage()
    {
        return '<img src="/images/scores/awards/' . $this->award_id . '-84.png" alt="">';
    }

    public function descriptionClass()
    {
        return 'career-achievement__sand';
    }

    /**
     * Возвращает модель награды
     *
     * @return ScoreAward
     */
    public function getAward()
    {
        if ($this->_award === null)
            $this->_award = ScoreAward::model()->findByPk($this->award_id);

        return $this->_award;
    }
}