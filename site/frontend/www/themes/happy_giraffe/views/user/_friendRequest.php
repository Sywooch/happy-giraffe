<?php
    $user = ($direction == 'incoming') ? $data->from : $data->to;
?>

<li class="clearfix">
    <?php $this->widget('AvatarWidget', array(
        'user' => $user,
    )); ?>
    <div class="details">
        <?php echo CHtml::link($user->fullName, $user->profileUrl, array('class' => 'username')); ?>
        <?php if ($direction == 'incoming'): ?>
            <div class="actions">
                <a href="<?php echo $this->createUrl('friendRequests/reply', array('request_id' => $data->id, 'new_status' => 'accepted')); ?>" class="btn btn-green-ssmall"><span><span>Дружить</span></span></a>
                &nbsp;
                <a href="<?php echo $this->createUrl('friendRequests/reply', array('request_id' => $data->id, 'new_status' => 'declined')); ?>" class="pseudo">Отклонить</a>
            </div>
        <?php else: ?>
            <div class="actions">
                <a href="" class="btn btn-blue-small"><span><span>Повторить</span></span></a>
                &nbsp;
                <a href="" class="pseudo">Отменить</a>
            </div>
        <?php endif; ?>
    </div>
</li>