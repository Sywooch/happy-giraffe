<?php
    Yii::import('application.widgets.user.UserCoreWidget');

    $this->widget('application.widgets.user.UserDuelWidget', array(
        'user' => $users[$action->user_id],
        'question_id' => $action->data['id'],
        'activityType' => $type,
    ));
?>