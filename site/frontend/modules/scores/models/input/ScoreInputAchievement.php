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
    public $achievement_id;

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
}