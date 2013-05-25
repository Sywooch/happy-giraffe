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
     * @param $user_scores UserScores
     */
    public function check($user_scores)
    {
        if ($this->getStepsCount($user_scores->user) >= 6) {
            $user_scores->full = 1;
            $user_scores->level_id = 1;
            $user_scores->save();

            $this->user_id = $user_scores->user_id;
            $this->insert();
        }
    }

    /**
     * Возвращает количество выполненных шагов
     *
     * @param $user User
     * @return int
     */
    private function getStepsCount($user)
    {
        $count = 0;
        $steps = array(ScoreAction::ACTION_PROFILE_BIRTHDAY,
            ScoreAction::ACTION_PROFILE_PHOTO, ScoreAction::ACTION_PROFILE_FAMILY,
            ScoreAction::ACTION_PROFILE_INTERESTS, ScoreAction::ACTION_PROFILE_EMAIL,
            ScoreAction::ACTION_PROFILE_LOCATION);
        foreach ($steps as $step)
            if ($this->stepComplete($user, $step))
                $count++;

        return $count;
    }

    /**
     * Выполнен ли пользователем указанный шаг
     *
     * @param $user User
     * @param $step_id int
     * @return bool
     */
    private function stepComplete($user, $step_id)
    {
        switch ($step_id) {
            case ScoreAction::ACTION_PROFILE_BIRTHDAY:
                return !empty($user->birthday);
            case ScoreAction::ACTION_PROFILE_PHOTO:
                return !empty($user->avatar_id);
            case ScoreAction::ACTION_PROFILE_FAMILY:
                return !empty($user->relationship_status);
            case ScoreAction::ACTION_PROFILE_INTERESTS:
                return !empty($user->interests);
            case ScoreAction::ACTION_PROFILE_EMAIL:
                return !empty($user->email_confirmed);
            case ScoreAction::ACTION_PROFILE_LOCATION:
                return !empty($user->userAddress);
        }

        return true;
    }
}