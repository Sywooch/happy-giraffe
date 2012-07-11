<?php if (!Yii::app()->user->isGuest):?>
    <?php if ($user->isFriend(Yii::app()->user->id)): ?>
        <span class="friend">друг</span>
    <?php elseif ($user->isInvitedBy(Yii::app()->user->id)): ?>
        <a href="javascript:$.fancybox.open('Приглашение уже выслано.');" class="add-friend tooltip" title="Приглашение выслано"></a>
    <?php else: ?>
        <a href="javascript:" onclick="sendInvite(this, <?php echo $user->id; ?>);" class="add-friend tooltip" title="Пригласить в друзья"></a>
    <?php endif; ?>
<?php else: ?>
    <a href="#login" class="add-friend fancy"></a>
<?php endif ?>