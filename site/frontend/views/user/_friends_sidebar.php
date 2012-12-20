<?php $this->renderPartial('_userinfo', array('user' => $this->user)); ?>

<?php if ($this->user->id == Yii::app()->user->id): ?>
    <div class="club-topics-list-new">

        <div class="block-title">Друзья</div>

        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Мои друзья',
                    'url' => array('user/friends', 'user_id' => $this->user->id),
                    'template' => '<span>{menu}</span><div class="count">' . $this->user->getFriendsCount() . '</div>',
                    'active' => $this->action->id == 'friends' && (! isset($this->actionParams['show']) || $this->actionParams['show'] == 'all'),
                ),
                array(
                    'label' => 'Что нового у друзей',
                    'url' => array('/whatsNew/friends/index'),
                    'template' => '<span>{menu}</span>',
                    'visible' => $this->user->getFriendsCount() > 0 && $this->user->id == Yii::app()->user->id,
                ),
                array(
                    'label' => 'Сейчас на сайте',
                    'url' => array('user/friends', 'user_id' => $this->user->id, 'show' => 'online'),
                    'template' => '<span>{menu}</span><div class="count">' . $this->user->getFriendsCount(true) . '</div>',
                    'visible' => $this->user->getFriendsCount() > 0,
                ),
                array(
                    'label' => 'Хотят дружить',
                    'url' => array('user/myFriendRequests', 'direction' => 'incoming'),
                    'template' => '<span>{menu}</span><div class="count">' . $this->user->getFriendRequestsCount('incoming') . '</div>',
                ),
                array(
                    'label' => 'Я хочу дружить',
                    'url' => array('user/myFriendRequests', 'direction' => 'outgoing'),
                    'template' => '<span>{menu}</span><div class="count">' . $this->user->getFriendRequestsCount('outgoing') . '</div>',
                ),
            ),
        ));
        ?>

    </div>
<?php endif; ?>