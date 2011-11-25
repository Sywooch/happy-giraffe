<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Изменить пароль</b>',
); ?>

<?php $form = $this->beginWidget('CActiveForm'); ?>
	<div class="profile-form-in" style="float:left;margin-left:0;">
	
		<?php echo $form->errorSummary($this->user); ?>
	
		<div class="row">
			<div class="row-title">Текущий пароль</div>
			<div class="row-elements">
				<div class="col">
					<?php echo $form->passwordField($this->user, 'current_password'); ?><br/>
				</div>
			</div>
		</div>
	
		<div class="row">
			<div class="row-title">Новый пароль</div>
			<div class="row-elements">
				<div class="col">
					<?php echo $form->passwordField($this->user, 'new_password'); ?><br/>
					<small>Придумайте сложный пароль, который нельзя подобрать,<br/>от 6 до 12 символов — цифры и английские буквы.</small>
				</div>
			</div>
		</div>
	
		<div class="row">
			<div class="row-title">Новый пароль еще раз</div>
			<div class="row-elements">
				<div class="col">
					<?php echo $form->passwordField($this->user, 'new_password_repeat'); ?><br/>
				</div>
			</div>
		</div>
	
		<div class="row captcha">
			<div class="row-title">Код:</div>
			<div class="col">
				<div class="captcha-img"><?php $this->widget('Captcha', array('showRefreshButton' => FALSE, 'selector' => '.refresh')); ?></div>
				<a href="" class="refresh">Обновить картинку</a>
			</div>
			<div class="col">
				<div class="row-elements"><?php echo $form->textField($this->user, 'verifyCode'); ?></div>
				<div class="row-bottom">Введите цифры, которые Вы видите на картинке.</div>
			</div>
		</div>
	
		<div class="row-btn-right">
			<button class="btn btn-orange"><span><span>Изменить</span></span>
		</div>
	
	</div>
</div>
<div class="bottom">
	&nbsp;
</div>
<?php $this->endWidget(); ?>