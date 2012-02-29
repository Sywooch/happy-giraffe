<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class LocaionWidget extends UserCoreWidget
{
    public function run()
    {
        if (empty($this->user->country_id))
            return ;

        $this->render('location');
    }
}
