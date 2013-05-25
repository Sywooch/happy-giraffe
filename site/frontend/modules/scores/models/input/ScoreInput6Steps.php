<?php
/**
 * Class ScoreInput
 *
 * Начисление баллов пользователю за прохождение 6 первых шагов
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInput6Steps extends ScoreInput
{
    public $type = self::TYPE_6_STEPS;

    /**
     * @var ScoreInput6Steps
     */
    private static $_instance;

    /**
     * @return ScoreInput6Steps
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
     * @param $user_id
     */
    public function check($user_id)
    {

    }
}