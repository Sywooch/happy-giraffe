<?php if ($type == 'friends'): ?>

    <div class="activity-friend clearfix">

        <?php $user = User::model()->findByPk($user_id); ?>

        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $user,
            'location' => false,
            'sendButton' => false
        ));?>
    </div>

<?php endif; ?>