<?php
/**
 * @author Никита
 * @date 26/02/15
 */

class LeadersWidget extends CWidget
{
    public $participant;

    public function run()
    {
        $this->render('ParticipantWidget');
    }
}