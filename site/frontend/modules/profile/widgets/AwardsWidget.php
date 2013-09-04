<?php

class AwardsWidget extends UserCoreWidget
{
    /**
     * @var ScoreUserAchievement[]|ScoreUserAward[]
     */
    public $awards;
    public function init()
    {
        parent::init();
        $this->awards = UserScores::model()->getAwardsWithAchievements($this->user->id, 12);
        $this->visible = !empty($this->awards);
    }
}
