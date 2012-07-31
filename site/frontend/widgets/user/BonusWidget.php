<?php
/**
 * Author: alexk984
 * Date: 31.07.12
 */
class BonusWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (!$this->user->getUserAddress()->hasCity())
            return ;

    }
}