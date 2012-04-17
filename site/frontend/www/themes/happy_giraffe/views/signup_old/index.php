<?php
	$cs = Yii::app()->clientScript;
	$url = CController::createUrl('signup/validate', array('step' => '1'));
	$js_step_1 = "
$('#next_1').click(function() {
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: " . CJSON::encode($url) . ",
		data: $('#signup').serialize(),
		success: function(response) {
			if (response.status == 'ok')
			{
				$('#step_1 .errors').html('');
			
				$('#step_1').hide();
				$('#step_2').show();
				$('.steps li.active').removeClass('active');
				$('.steps li:nth-child(2)').addClass('active');
			}
			else
			{
				$('#step_1 .errors').html(response.errors);
			}
		}
	});
	return false;
});";
	$url = CController::createUrl('signup/validate', array('step' => '2'));
	$js_step_2 = "
$('#next_2').click(function() {
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: " . CJSON::encode($url) . ",
		data: $('#signup').serialize(),
		success: function(response) {
			if (response.status == 'ok')
			{
				$('#step_2 .errors').html('');
			
				$('#signup').submit();
			}
			else
			{
				$('#step_2 .errors').html(response.errors);
			}
		}
	});
	return false;
});
$('.inc').click(function() {
	var input = $(this).prev();
	var old_val = parseInt(input.val());
	input.val(old_val + 1);
});
$('.dec').click(function() {
	var input = $(this).next();
	var old_val = parseInt(input.val());
	if (old_val > 0) input.val(parseInt(input.val()) - 1);
});
$('#agree').change(function() {
	$('#next_2').toggleClass('disabled').toggleDisabled();
});";
	$js_functions = "
(function($) {
    $.fn.toggleDisabled = function(){
        return this.each(function(){
            this.disabled = !this.disabled;
        });
    };
})(jQuery);
function choose(val)
{
	$('#User_gender').val(val);
	
	$('.gender-select li.active').removeClass('active');
	$('.gender-select li:nth-child(' + (val + 1) + ')').addClass('active');
	$('.members-count').show();
}";
	$css_signup = "
#step_2, .members-count {
	display: none;
}";
	$cs->registerScript('step_1', $js_step_1)->registerScript('step_2', $js_step_2)->registerScript('choose', $js_functions, CClientScript::POS_HEAD)->registerCss('signup', $css_signup);
?>

<div id="registration" class="page">
	
	<div class="wrapper">
		
		<div class="registration-t"></div>
		
		<div class="wrapper-in">
			
			<div class="header">
				
				<!--<div class="a-right login-link">
					<span class="login-q">&mdash; Если Вы уже зарегистрированы?</span>
					<a href="#login" class="btn btn-orange fancy"><span><span>Вход на сайт</span></span></a>
				</div>-->
				
				<div class="logo-box"><a class="logo"></a></div>
				
			</div>
			
			<div class="content">
			
				<div class="title">Регистрация</div>
				
				<?php $form = $this->beginWidget('CActiveForm', array('id' => 'signup', 'action' => CController::createUrl('signup/finish'))); ?>
			
					<div class="form" id="step_1">
					
						<div class="errors"></div>
				
						<div class="highlight">
						
							<? if ($regdata === NULL): ?>
					
								<div class="a-right login-social">
						
									<span>Войти с помощью<br/>социальной сети</span>
                                        <div class="socials socials-rect">
										<?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index')); ?>
                                        </div>
						
								</div>
					
								<div class="row">
									<div class="row-title">Ваше имя:</div>
									<div class="row-elements"><?php echo $form->textField($model, 'first_name'); ?></div>
									<div class="row-bottom">Укажите ваше настоящее имя, до 50 символов.</div>
								</div>
					
								<div class="row">
									<div class="row-title">Ваш e-mail:</div>
									<div class="row-elements"><?php echo $form->textField($model, 'email'); ?></div>
									<div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
								</div>
					
								<div class="row">
									<div class="row-title">Ваш пароль:</div>
									<div class="row-elements"><?php echo $form->passwordField($model, 'password'); ?></div>
									<div class="row-bottom">Придумайте сложный пароль, который нельзя подобрать, <br/>от 6 до 12 символов — цифры и английские буквы.</div>
								</div>
					
								<div class="row captcha">
									<div class="row-title">Код:</div>
									<div class="a-right">
										<div class="row-elements"><?php echo $form->textField($model, 'verifyCode'); ?></div>
										<div class="row-bottom">Введите цифры, которые Вы видите на картинке.</div>
									</div>
									<div class="row-elements"><?php $this->widget('Captcha', array('showRefreshButton' => FALSE, 'selector' => '.refresh')); ?></div>
									<div class="row-bottom"><a href="" class="refresh">Обновить</a></div>
								</div>
								
							<? else: ?>
							
								<?php echo $form->hiddenField($model, 'first_name', array('value' => $regdata['name'])); ?>


                                <div class="user-box">
                                    <?php if(isset($regdata['photo']) && 0 == 1): ?>
                                        <?php echo $form->hiddenField($model, 'photo', array('value' => $regdata['photo'])); ?>
                                        <div class="ava"><?php echo CHtml::image($regdata['photo']); ?></div>
                                    <?php endif; ?>
                                    <?php echo $regdata['name']; ?>
                                </div>
					
								<div style="margin-left:300px;">
									<div class="row">
										<div class="row-title">Ваш e-mail:</div>
										<div class="row-elements"><?php echo $form->textField($model, 'email', array('value' => isset($regdata['email']) ? $regdata['email'] : '')); ?></div>
										<div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
									</div>
						
									<div class="row">
										<div class="row-title">Ваш пароль:</div>
										<div class="row-elements"><?php echo $form->passwordField($model, 'password'); ?></div>
										<div class="row-bottom">Придумайте сложный пароль, который нельзя подобрать, <br/>от 6 до 12 символов — цифры и английские буквы.</div>
									</div>
								</div>
							
							<? endif; ?>
						</div>
				
						<div class="form-bottom">
							<button class="btn btn-green-arrow-big" id="next_1"><span><span>Продолжить</span></span></button>
						</div>
				
					</div>
					
					<div class="form" id="step_2">
					
						<div class="errors"></div>
				
						<div class="clearfix">
							<div class="gender-select">
								<big>Вы:</big>
								<ul class="clearfix">
									<li>
										<a href="" class="btn btn-yellow-small" onclick="choose(0); return false;"><span><span>Выбрать</span></span></a>
										<span class="original"><img src="/images/gender_female.gif" /></span>
										<span class="selected"><img src="/images/gender_female_selected.gif" /></span>
										<br/>
										<div class="info">
											<span>Женщина</span>
											старше 18 лет
										</div>
									</li>
									<li>
										<a href="" class="btn btn-yellow-small" onclick="choose(1); return false;"><span><span>Выбрать</span></span></a>
										<span class="original"><img src="/images/gender_male.gif" /></span>
										<span class="selected"><img src="/images/gender_male_selected.gif" /></span>
										<br/>
										<div class="info">
											<span>Мужчина</span>
											старше 18 лет
										</div>
									</li>
								
								</ul>
								<?php echo $form->hiddenField($model, 'gender'); ?>
							</div>
							<div class="members-count">
								<big>У Вас в семье <span>(или о ком Вы заботитесь):</span></big>
								<div class="subtitle">
									<span>Дети</span>
									<p>Отметьте количество детей каждого возраста в Вашей семье</p>
								</div>
								<ul>
									<li>
										<div class="img"><span class="valign"></span><img src="/images/age_01.gif" /></div>
										<div class="age-title">ждем ребенка</div>
										<div class="controls"><?php echo CHtml::checkBox('age_group[0]', TRUE, array('value' => 1, 'uncheckValue' => 0)); ?></div>
									</li>
									<li>
										<div class="img"><span class="valign"></span><img src="/images/age_02.gif" /></div>
										<div class="age-title"><b>0-1</b></div>
										<div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
									</li>
									<li>
										<div class="img"><span class="valign"></span><img src="/images/age_03.gif" /></div>
										<div class="age-title"><b>1-3</b></div>
										<div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
									</li>
									<li>
										<div class="img"><span class="valign"></span><img src="/images/age_04.gif" /></div>
										<div class="age-title"><b>3-7</b></div>
										<div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
									</li>
									<li>
										<div class="img"><span class="valign"></span><img src="/images/age_05.gif" /></div>
										<div class="age-title"><b>7-18</b></div>
										<div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
									</li>
									
								</ul>
							</div>
						</div>
					
						<div class="form-bottom">
							<label><input type="checkbox" id="agree" /> Я принимаю условия, изложенные в</label> <a href="">Пользовательском соглашении</a>
							<button class="btn btn-green-arrow-big disabled" disabled="disabled" id="next_2"><span><span>Зарегистрироваться</span></span></button>
						</div>
					
					</div>
					
				<?php $this->endWidget(); ?>
				
			</div>
			
		</div>
		
		<div class="registration-b"></div>
	
	</div>
	
</div>