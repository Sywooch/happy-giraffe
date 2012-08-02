<?php
/**
 * Author: choo
 * Date: 18.05.2012
 */
class UserDuelWidget extends UserCoreWidget
{
    public $question_id = null;
    public $activityType = false;

    public $question = null;
    public $myAnswer;
    public $opponentAnswer;

    public function init()
    {
        parent::init();
        $this->question = ($this->question_id == null) ? $this->user->activeQuestion : DuelQuestion::model()->with('answers')->findByPk($this->question_id);
        if ($this->question) {
            if ($this->question->answers[0]->user_id == $this->user->id) {
                $this->myAnswer = $this->question->answers[0];
                $this->opponentAnswer = $this->question->answers[1];
            } else {
                $this->myAnswer = $this->question->answers[1];
                $this->opponentAnswer = $this->question->answers[0];
            }
        }
        $this->visible = $this->question !== null;
    }
}
