<div class="user-friends clearfix">

    <div class="box-title">Друзья <?php echo CHtml::link('Все друзья (' . $user->getFriendsCount() . ')', array('user/friends', 'user_id' => $user->id)); ?></div>

    <ul>
        <?php foreach ($friends->data as $f): ?>
            <li><?php $this->widget('AvatarWidget', array('user' => $f)); ?></li>
        <?php endforeach; ?>
    </ul>

</div>