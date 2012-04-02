<?php

class UserFriendsWidget extends UserCoreWidget
{
    public $limit = 9;
    private $_friends;

    public function init()
    {
        parent::init();
        $this->_friends = $this->user->getFriends(array(
            'limit' => $this->limit,
            'order' => 'RAND()',
            'condition' => 'avatar IS NOT NULL',
        ));

        $this->visible = ($this->isMyProfile && !empty($this->_friends->data)) || (User::model()->count($this->_friends->criteria) >= $this->limit);
    }

    public function run()
    {
        if ($this->visible) {
            $this->render(get_class($this), array(
                'user' => $this->user,
                'friends' => $this->_friends,
            ));
        }
    }
}
