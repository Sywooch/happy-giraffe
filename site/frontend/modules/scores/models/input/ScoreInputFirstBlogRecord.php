<?php
/**
 * Class ScoreInput
 *
 * Начисление баллов пользователю за первую запись в личном блоге
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputFirstBlogRecord extends ScoreInput
{
    public $type = self::TYPE_FIRST_BLOG_RECORD;

    /**
     * @var ScoreInputFirstBlogRecord
     */
    private static $_instance;

    /**
     * @return ScoreInputFirstBlogRecord
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
            self::$_instance = new self();

        return self::$_instance;
    }

    /**
     * Проверить пользователя на выполнение 6-ти шагов
     *
     * @param $user_scores UserScores
     */
    public function check($user_scores)
    {
        if ($this->getStepsCount($user_scores->user) >= 6) {
            $user_scores->full = 1;
            $user_scores->level_id = 1;
            $user_scores->save();

            $this->user_id = $user_scores->user_id;
            $this->scores = $this->getScores();
            $this->insert();
        }
    }
}