<?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array(
                'label' => '<span>Все</span>' . $this->user->getFriendsCount(),
                'url' => array('user/friends', 'user_id' => $this->user->id),
                'active' => $this->action->id == 'friends' && (! isset($this->actionParams['show']) || $this->actionParams['show'] == 'all'),
            ),
            array(
                'label' => '<span>Сейчас на сайте</span>' . $this->user->getFriendsCount(true),
                'url' => array('user/friends', 'user_id' => $this->user->id, 'show' => 'online'),
            ),
            array(
                'label' => '<span>Предложения дружбы</span>' . $this->user->getFriendRequestsCount('incoming'),
                'url' => array('user/myFriendRequests', 'direction' => 'incoming'),
                'visible' => ! Yii::app()->user->isGuest,
            ),
            array(
                'label' => '<span>Мои предложения</span>' . $this->user->getFriendRequestsCount('outgoing'),
                'url' => array('user/myFriendRequests', 'direction' => 'outgoing'),
                'visible' => ! Yii::app()->user->isGuest,
            ),
        ),
        'encodeLabel' => false,
    ));
?>