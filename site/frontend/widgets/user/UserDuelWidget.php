<?php
/**
 * Author: choo
 * Date: 18.05.2012
 */
class UserDuelWidget extends UserCoreWidget
{
    public $question = null;
    public $myAnswer;
    public $opponentAnswer;

    public function init()
    {
        parent::init();
        $this->question = $this->user->activeQuestion;
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
