<div class="login-box">
    <span class="welcome"><b>Добро пожаловать,</b> <a href="<?php echo Yii::app()->createUrl('profile/index'); ?>"><?php echo Yii::app()->user->first_name; ?><?php if (Yii::app()->user->last_name) echo ' ' . Yii::app()->user->last_name; ?>!</a></span>
    <?php echo CHtml::link('Выход', Yii::app()->createUrl('site/logout')); ?>
</div>