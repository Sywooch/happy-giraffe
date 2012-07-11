<?php if ($user->isFriend(Yii::app()->user->id)): ?>
    <a href="javascript:" onclick="deleteFriend(this, <?php echo $user->id; ?>);" class="remove-friend tooltip" title="Удалить из друзей"></a>
<?php elseif ($user->isInvitedBy(Yii::app()->user->id)): ?>
    <a href="javascript:" class="pending-friend"><span class="tip">Приглашение выслано</span></a>
<?php else: ?>
    <a href="javascript:" onclick="sendInvite(this, <?php echo $user->id; ?>);" class="add-friend tooltip" title="Пригласить в друзья"></a>
<?php endif; ?>