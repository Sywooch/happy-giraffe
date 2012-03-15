<?php
    $user = ($direction == 'incoming') ? $data->from : $data->to;
?>

<li class="clearfix">
    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
        'user' => $user,
    )); ?>
    <div class="details">
        <?php if ($direction == 'incoming'): ?>
            <div class="actions">
                <a href="<?php echo $this->createUrl('friendRequests/update', array('request_id' => $data->id, 'action' => 'accept')); ?>" class="btn btn-green-ssmall"><span><span>Дружить</span></span></a>
                &nbsp;
                <a href="<?php echo $this->createUrl('friendRequests/update', array('request_id' => $data->id, 'action' => 'decline')); ?>" class="pseudo">Отклонить</a>
            </div>
        <?php else: ?>
            <div class="actions">
                <a href="<?php echo $this->createUrl('friendRequests/update', array('request_id' => $data->id, 'action' => 'retry')); ?>" class="btn btn-blue-small"><span><span>Повторить</span></span></a>
                &nbsp;
                <a href="<?php echo $this->createUrl('friendRequests/update', array('request_id' => $data->id, 'action' => 'cancel')); ?>" class="pseudo">Отменить</a>
            </div>
        <?php endif; ?>
    </div>
</li>