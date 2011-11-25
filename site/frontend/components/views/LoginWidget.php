<div style="display:none">
	<div id="login" class="popup">
		
		<a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>
		
		<div class="popup-title">Вход на сайт</div>
		
		<?php $form = $this->beginWidget('CActiveForm', array('action' => Yii::app()->createUrl('site/login'))); ?>
			<div class="form">
				
				<div class="a-right login-btn">
					
					<div class="remember">
						<label><input type="checkbox" /><br/>Запомнить меня</label>
					</div>
					
					<button class="btn btn-green-arrow-big"><span><span>Войти</span></span></button>
					
				</div>
				
				<div class="row">
					<div class="row-title">Ваш e-mail:</div>
					<div class="row-elements"><?php echo $form->textField($model, 'email'); ?></div>
				</div>
				
				<div class="row">
					<div class="row-title">Ваш пароль:</div>
					<div class="row-elements"><?php echo $form->passwordField($model, 'password'); ?></div>
					<div class="row-bottom"><a href="">Забыли пароль?</a></div>
				</div>
				
				<div class="row row-social">
					Быстрый вход:
					&nbsp;
					<?php Yii::app()->eauth->renderWidget(array('mode' => 'login', 'action' => 'site/login')); ?>
				</div>
				
				<div class="reg-link">
					
					<div class="a-right">
						<a class="btn btn-orange" href="<?php echo Yii::app()->createUrl('signup'); ?>"><span><span>Зарегистрироваться</span></span></a>
					</div>
					
					<div class="row"><span>Еще нет учетной записи?</span></div>
					
				</div>
				
			</div>
		<?php $this->endWidget(); ?>
		
	</div>
</div>