<div class="user-friends clearfix">

    <div class="box-title">Друзья <a href="">Все друзья (<?php echo $user->getFriendsCount(); ?>)</a></div>

    <ul>
        <?php foreach ($friends as $f): ?>
            <li><?php echo CHtml::link(CHtml::image($f->pic_small->getUrl('ava')), array('user/profile', 'user_id' => $f->id)); ?></li>
        <?php endforeach; ?>
    </ul>

</div>