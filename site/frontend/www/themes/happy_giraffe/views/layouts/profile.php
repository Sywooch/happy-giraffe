<?php
	$cs = Yii::app()->clientScript;
	$cs->registerCssFile('/stylesheets/profile.css');
?>
<?php $this->beginContent('//layouts/shop'); ?>
<div id="profile" class="clearfix">
	
	<div class="user-box">
		<?php $this->widget('AvatarWidget', array('user' => $this->user)); ?>
		<?php echo $this->user->first_name; ?>
	</div>
	
	<div class="profile-title">Мои настройки</div>
	
	<div class="clear"></div>
	
	<div class="highlight clearfix">
		<div class="profile-nav">
			<?php 
				$this->widget('zii.widgets.CMenu', array(
				'items' => array(
					array('label' => 'Личная информация', 'url' => array('/profile/index'), 'active' => $this->action->id == 'index'),
					array('label' => 'Ваша фотография', 'url' => array('/profile/photo'), 'active' => $this->action->id == 'photo'),
					array('label' => 'Моя семья', 'url' => array('/profile/family'), 'active' => $this->action->id == 'family'),
					array('label' => 'Доступ', 'url' => array('/profile/access'), 'active' => $this->action->id == 'access'),
					//array('label' => 'Черный список', 'url' => array('/profile/blacklist'), 'active' => $this->action->id == 'blacklist'),
					//array('label' => 'Подписка', 'url' => array('/profile/subscription'), 'active' => $this->action->id == 'subscription'),
					array('label' => 'Социальные сети', 'url' => array('/profile/socials'), 'active' => $this->action->id == 'socials'),
					array('label' => 'Изменить пароль', 'url' => array('/profile/password'), 'active' => $this->action->id == 'password'),
				)));
			?>
		</div>
	
		<?php echo $content; ?>
	
</div>
<?php $this->endContent(); ?>