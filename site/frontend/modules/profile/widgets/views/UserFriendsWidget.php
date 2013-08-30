<div class="widget-friends clearfix">
    <div class="clearfix">
        <?php if (!$this->isMyProfile):?>
            <a href="<?=Yii::app()->createUrl('/profile/default/friends', array('user_id' => $user->id)) ?>" class="heading-small">Мои друзья </a>&nbsp;<span class="heading-small color-gray">(<?=$user->getFriendsCount() ?>)</span>
        <?php else: ?>
            <a href="<?=Yii::app()->createUrl('/friends/default/index') ?>" class="heading-small">Мои друзья</a>&nbsp;<span class="heading-small color-gray">(<?=$user->getFriendsCount() ?>)</span>
        <?php endif ?>
    </div>
    <ul class="widget-friends_ul clearfix">
        <?php foreach ($friends as $f): ?>
            <li class="widget-friends_i">
                <?php $this->widget('Avatar', array('user' => $f)) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>