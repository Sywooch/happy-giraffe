<?php
/**
 * Author: alexk984
 * Date: 22.11.12
 */
class PregnantWidget extends UserCoreWidget
{
    public $baby;

    public function init()
    {
        parent::init();

        $this->baby = $this->user->getPregnantBaby();
        $this->visible = $this->isMyProfile && $this->baby !== null;
    }
}