<?php
    Yii::import('application.widgets.user.UserCoreWidget');

    $this->widget('application.widgets.user.UserDuelWidget', array(
        'user' => $this->user,
        'question_id' => $action->data['id'],
        'boxTitle' => 'Принял участие в <span>дуэли</span>',
        'outerCssClass' => 'user-duel list-item',
    ));
?>