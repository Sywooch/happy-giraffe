<div class="widget-friends clearfix">
    <div class="clearfix">
        <span class="heading-small">Мои друзья <span class="color-gray">(<?=$user->getFriendsCount() ?>)</span> </span>
        <a href="<?=Yii::app()->createUrl('user/friends', array('user_id' => $user->id)) ?>" class="padding-l20">Все друзья</a>
    </div>
    <ul class="widget-friends_ul clearfix">
        <?php foreach ($friends as $f): ?>
            <li class="widget-friends_i">
                <?php $this->widget('UserAvatarWidget', array('user' => $f)) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>