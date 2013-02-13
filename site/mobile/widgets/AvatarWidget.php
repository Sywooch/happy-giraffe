<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/11/13
 * Time: 8:17 PM
 * To change this template use File | Settings | File Templates.
 */
class AvatarWidget extends CWidget
{
    public $user;
    public $size = 'small';

    public function run()
    {
        $this->render('AvatarWidget', array('user' => $this->user));
    }
}
