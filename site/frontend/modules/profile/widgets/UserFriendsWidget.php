<?php

class UserFriendsWidget extends UserCoreWidget
{
    public $limit = 9;
    private $_friends;

    public function init()
    {
        parent::init();
        $criteria = new CDbCriteria;
        $criteria->limit = $this->limit;
        $criteria->order = 'RAND()';
        $criteria->condition = 'avatar_id IS NOT NULL';
        $criteria->with = array(
            'avatar' => array(
                'select' => array('author_id', 'fs_name')
            )
        );
        $this->_friends = User::model()->findAll($this->user->getFriendsCriteria($criteria));

        $this->visible = $this->isMyProfile || (count($this->_friends) >= $this->limit);
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
