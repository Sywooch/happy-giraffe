<?php if ($user->isFriend(Yii::app()->user->id)): ?>
    <a href="javascript:" onclick="deleteFriend(this, <?php echo $user->id; ?>);" class="remove-friend"><span class="tip">Удалить из друзей</span></a>
<?php elseif ($user->isInvitedBy(Yii::app()->user->id)): ?>
    <a href="javascript:" class="pending-friend"><span class="tip">Приглашение выслано</span></a>
<?php else: ?>
    <a href="javascript:" onclick="sendInvite(this, <?php echo $user->id; ?>);" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
<?php endif; ?>