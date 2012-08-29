<?php if (Yii::app()->user->isGuest): ?>
<?php echo CHtml::link('', '#login', array('class' => 'new-message fancy tooltip', 'title'=>'Написать сообщение', 'data-theme'=>"white-square")); ?>
<?php else: ?>
<?php echo CHtml::link('', 'javascript:void(0)', array('class' => 'new-message tooltip', 'title'=>'Написать сообщение', 'onclick' => 'Messages.open(' . $user->id . ')')); ?>
<?php endif ?>