<?php if (Yii::app()->user->isGuest): ?>
<?php echo CHtml::link('', '#login', array('class' => 'new-message fancy tooltip', 'title'=>'Написать сообщение', 'data-theme'=>"white-square")); ?>
<?php else: ?>
<?php if (! in_array(Yii::app()->user->id, array(12936, 22, 9990, 83)) && ! Yii::app()->user->checkAccess('commentator_panel')): ?>
<?php echo CHtml::link('', 'javascript:void(0)', array('class' => 'new-message tooltip', 'title'=>'Написать сообщение', 'onclick' => 'Messages.open(' . $user->id . ')')); ?>
<?php else: ?>
    <?php echo CHtml::link('', array('/messaging/default/index', 'interlocutorId' => $user->id), array('class' => 'new-message tooltip', 'title'=>'Написать сообщение')); ?>
<?php endif; ?>
<?php endif ?>