<div class="user-friends clearfix">

    <div class="box-title">Друзья <?php echo CHtml::link('Все друзья (' . $user->getFriendsCount() . ')', array('user/friends', 'user_id' => $user->id)); ?></div>

    <ul>
        <?php foreach ($friends->data as $f): ?>
            <li><?php echo CHtml::link(CHtml::image($f->pic_small->getUrl('ava')), array('user/profile', 'user_id' => $f->id)); ?></li>
        <?php endforeach; ?>
    </ul>

</div>