<?php
    $user = ($direction == 'incoming') ? $data->from : $data->to;
?>

<li>
    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
        'user' => $user,
        'location' => false,
        'friendRequest' => array(
            'direction' => $direction,
            'id' => $data->id,
        ),
    )); ?>
</li>