<div class="user-friends clearfix">

    <div class="box-title">Друзья <?php echo CHtml::link('Все друзья (' . $user->getFriendsCount() . ')', array('user/friends', 'user_id' => $user->id)); ?></div>

    <ul>
        <?php foreach ($friends as $f): ?>
            <li><?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $f, 'small' => true)); ?></li>
        <?php endforeach; ?>
    </ul>

</div>