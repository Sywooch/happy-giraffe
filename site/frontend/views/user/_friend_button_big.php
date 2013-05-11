<?php if (!Yii::app()->user->isGuest):?>
    <?php if (Friend::areFriends(Yii::app()->user->id, $user->id)): ?>

        <?php elseif ($user->isInvitedBy(Yii::app()->user->id)): ?>
            <a href="javascript:void(0)" class="add-friend"><i class="icon"></i>Приглашение<br>уже выслано</a>
        <?php else: ?>
            <a href="javascript:;" class="add-friend" onclick="sendInvite(this, <?php echo $user->id; ?>);"><i class="icon"></i>Пригласить<br>в друзья</a>
    <?php endif; ?>
<?php else: ?>
    <a href="#login" class="add-friend fancy" data-theme="white-square"><i class="icon"></i>Пригласить<br>в друзья</a>
<?php endif ?>