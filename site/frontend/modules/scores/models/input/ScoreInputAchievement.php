<?php
/**
 * Class ScoreInputAchievement
 *
 * Начисление баллов пользователю за новое фото в фотоальбомах
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputAchievement extends ScoreInput
{
    public $type = self::TYPE_ACHIEVEMENT;
    /**
     * @var int
     */
    public $achievement_id;
    /**
     * @var ScoreAchievement
     */
    private $_achievement;

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

    public function __construct()
    {
    }

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $achievement ScoreAchievement достижение
     */
    public function add($user_id, $achievement)
    {
        $this->user_id = $user_id;
        $this->scores = $achievement->scores;
        parent::insert(array('achievement_id' => $achievement->id));
    }

    /**
     * Возвращает иконку
     * @return string
     */
    public function getImage()
    {
        return '<img src="/images/scores/achievements/' . $this->achievement_id . '-84.png" alt="">';
    }

    /**
     * Название
     * @return string
     */
    public function getTitle()
    {
        return 'Новое достижение<br>' . $this->getAchievement()->title;
    }

    /**
     * @return ScoreAchievement
     */
    public function getAchievement()
    {
        if ($this->_achievement === null) {
            $this->_achievement = ScoreAchievement::model()->findByPk($this->achievement_id);
        }

        return $this->_achievement;
    }

    public function descriptionClass()
    {
        return 'career-achievement__green';
    }
}