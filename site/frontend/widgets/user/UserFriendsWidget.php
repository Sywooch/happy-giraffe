<?php

class UserFriendsWidget extends UserCoreWidget
{
    public $limit;

    public function run()
    {
        if ($this->visible) {

            $friends = $this->user->getFriends(array(
                'limit' => $this->limit,
                'order' => 'RAND()',
                'condition' => 'pic_small != \'\'',
            ));

            $this->render(get_class($this), array(
                'user' => $this->user,
                'friends' => $friends,
            ));
        }
    }
}
