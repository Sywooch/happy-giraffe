<div class="login-box">
    <span class="welcome"><b>Добро пожаловать,</b> <a href="<?php echo Yii::app()->createUrl('/profile/index'); ?>"><?php echo CHtml::encode(Yii::app()->user->first_name); ?><?php if (Yii::app()->user->last_name) echo ' ' . CHtml::encode(Yii::app()->user->last_name); ?>!</a> <?php echo CHtml::link('профиль', array('/user/profile', 'user_id' => Yii::app()->user->id)); ?> <?php echo CHtml::link('друзья', array('/friendRequests/list')); ?></span>
    <?php echo CHtml::link('Выход', Yii::app()->createUrl('site/logout')); ?>
</div>