<div class="clearfix user-info-big">
    <?php
        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $user,
            'location' => false,
            'friendButton' => true,
        ));
    ?>
    <?php $this->renderPartial('_user_menu',compact('user')); ?>
    <?php if ($user->status): ?>
    <div class="text-status">
        <p><?=$user->status->purified->text?></p>
        <span class="tale"></span>
    </div>
    <?php endif; ?>
</div>