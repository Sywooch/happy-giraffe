<?php if (Yii::app()->user->isGuest): ?>
<?php echo CHtml::link('<span class="tip">Написать сообщение</span>', '#login', array('class' => 'new-message fancy')); ?>
<?php else: ?>
<?php echo CHtml::link('<span class="tip">Написать сообщение</span>', $user->getDialogUrl(), array('class' => 'new-message')); ?>
<?php endif ?>