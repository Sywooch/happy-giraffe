<div class="widget-friends clearfix">
    <div class="clearfix">
        <a href="<?=Yii::app()->createUrl('/profile/default/friends', array('user_id' => $user->id)) ?>" class="heading-small">Мои друзья <span class="color-gray">(<?=$user->getFriendsCount() ?>)</span> </a>
    </div>
    <ul class="widget-friends_ul clearfix">
        <?php foreach ($friends as $f): ?>
            <li class="widget-friends_i">
                <?php $this->widget('Avatar', array('user' => $f)) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>