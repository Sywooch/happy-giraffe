<?php if (Yii::app()->user->isGuest): ?>
<?php echo CHtml::link('', '#login', array('class' => 'new-message fancy tooltip', 'title'=>'Написать сообщение', 'data-theme'=>"white-square")); ?>
<?php else: ?>
<?php echo CHtml::link('', $user->getDialogUrl(), array('class' => 'new-message tooltip', 'title'=>'Написать сообщение')); ?>
<?php endif ?>