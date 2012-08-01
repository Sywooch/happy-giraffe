<?php if (!Yii::app()->user->isGuest):?>
    <?php if ($user->isFriend(Yii::app()->user->id)): ?>
        <span class="friend">друг</span>
        <a href="javascript:void(0)" onclick="deleteFriend(this, <?php echo $user->id; ?>, <?=($this->controller->route == 'user/friends') ? 'true' : 'false'?>);" class="remove tooltip" title="Удалить из друзей"></a>
    <?php elseif ($user->isInvitedBy(Yii::app()->user->id)): ?>
        <a href="javascript:void(0)" onclick="$.fancybox.open('Приглашение уже выслано.');" class="add-friend tooltip" title="Приглашение выслано"></a>
    <?php else: ?>
        <a href="javascript:void(0)" onclick="sendInvite(this, <?php echo $user->id; ?>);" class="add-friend tooltip" title="Пригласить в друзья"></a>
    <?php endif; ?>
<?php else: ?>
    <a href="#login" class="add-friend fancy" data-theme="white-square"></a>
<?php endif ?>