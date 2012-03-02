<?php
/**
 * User: Eugene
 * Date: 29.02.12
 */
class UserAlbumWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || (!$this->isMyProfile && count($this->user->albums) > 0);
        if($this->isMyProfile && count($this->user->albums('albums:full')) === 0)
            $this->viewFile = '_album_empty';
    }
}
