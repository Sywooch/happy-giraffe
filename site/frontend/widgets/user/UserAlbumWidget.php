<?php
/**
 * User: Eugene
 * Date: 29.02.12
 */
class UserAlbumWidget extends UserCoreWidget
{
    public function init()
    {
        if(count($this->user->albums) == 0)
            $this->visible = false;
        parent::init();
    }
}
