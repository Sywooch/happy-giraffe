<?php Yii::app()->clientScript->registerCssFile('/stylesheets/cusel.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/javascripts/cusel.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/javascripts/checkbox.js'); ?>
<?php Yii::app()->clientScript->registerCss('oook', '
.cusel {height: 45px;}
.cuselFrameRight {background-position: right center;}
.cuselText {color: #C6C6C6; font-size: 16px; padding-top: 14px; height: 18px;}
'); ?>

<?php
Y::script()->registerScriptFile('http://pickpoint.ru/select/postamat.js');

$js = 'var toal_price='.ShopCart::getCost().';';
Y::script()->registerScript('total_var', $js, CClientScript::POS_HEAD);
?>

<div id="cart" class="clearfix">

	<div class="cart-title">Моя корзина</div>

	<div class="steps">
		<ul>
			<li><a>Мой заказ</a></li>
			<li class="active"><a>Информация</a></li>
			<li><a>Оплата</a></li>
			<li><a>Успешно</a></li>
		</ul>
	</div>

	<?php if(Y::isGuest()): ?>
    <div class="a-right login-link">
		<span class="login-q">&mdash; Я уже зарегистрирован</span>
		<a href="#login" class="btn btn-orange fancy"><span><span>Войти</span></span></a>
	</div>
	<?php endif; ?>

	<?php echo CHtml::beginForm('', 'post', array('id'=>'userInfo')); ?>
	
	<?php echo CHtml::hiddenField('OrderId', $order->order_id);?>

		<?php if(Y::isGuest()): ?>
		<div id="userInfoId" class="subtitle">Данные покупателя</div>

		<div class="highlight info-form">

			<div class="row clearfix">
				<div class="row-title">Персональные данные</div>
				<div class="row-elements">
					<div class="col">
						<?php echo CHtml::activeTextField($user, 'last_name', array(
							'class'=>'placeholder',
							'placeholder'=>'Фамилия',
							'value'=>'Фамилия',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="user_last_name"></div>
					</div>
					<div class="col">
						<?php echo CHtml::activeTextField($user, 'first_name', array(
							'class'=>'placeholder',
							'placeholder'=>'Имя',
							'value'=>'Имя',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="user_first_name"></div>
					</div>

				</div>
			</div>

			<div class="row clearfix">
				<div class="row-title">E-mail</div>
				<div class="row-elements">
					<div class="col">
						<?php echo CHtml::activeTextField($user, 'email', array(
							'class'=>'placeholder',
							'placeholder'=>'E-mail',
							'value'=>'E-mail',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="user_email"></div>
					</div>
				</div>
			</div>

			<div class="row clearfix">
				<div class="row-title">Телефон</div>
				<div class="row-elements">
<!--					<span class="code"><b>+7</b></span>
					<div class="col">
						<input type="text" value="Код" placeholder="Код" class="placeholder short" onfocus="unsetPlaceholder(this);" onblur="setPlaceholder(this);" />
					</div>-->
					<div class="col">
						<?php echo CHtml::activeTextField($user, 'phone', array(
							'class'=>'placeholder',
							'placeholder'=>'Номер телефона',
							'value'=>'Номер телефона',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="user_phone"></div>
					</div>

				</div>
			</div>

			<div class="row clearfix">
				<div class="row-title">&nbsp;</div>
				<div class="row-elements highlight">
					Введите пароль, чтобы получить доступ к статусу Вашего заказа<br/>
					<div class="col">
						<?php echo CHtml::activePasswordField($user, 'password'); ?>
						<div class="error-text" id="user_password"></div>
						<br/>
						(введите 6 или более символов)
					</div>
				</div>
			</div>


		</div>
		<?php endif; ?>


		<div id="infoAdressId" class="subtitle">Адрес доставки</div>

		<div class="highlight info-form">

			<div class="row clearfix">
				<div class="row-title">Регион / нас. пункт</div>
				<div class="row-elements">
					<div class="col">
						<?php echo CHtml::activeTextField($adress, 'adress_index', array(
							'class'=>'placeholder short',
							'placeholder'=>'Индекс',
							'value'=>'Индекс',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="adress_adress_index"></div>
					</div>
					<div class="col">
						<?php echo CHtml::activeDropDownList($adress, 'adress_region_id', $geo['regions']->getRegions(), array(
							'class'=>'empty',
							'empty'=>'Регион',
							'id'=>'seldist',
						)); ?>
						<div class="error-text" id="adress_adress_region_id"></div>
					</div>
					<div class="col">
						<?php echo CHtml::activeHiddenField($adress, 'adress_city_id', array(
							'id'=>'selcity',
						)); ?>
						<?php
						 $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'name' => 'adress_city_id',
							'source' => 'js:function(request, response){
								$.ajax({
									url: "'.$this->createUrl('cities').'",
									data: $.extend({id:$("#seldist").val()},request),
									dataType: "json",
									success: function(data) {
										response(data);
									}
								})
							}',
							'options' => array(
								'minLength' => '2',
//								'search' => 'js: function(){
//									var dist = $("#seldist option:selected").val();
//								}',
								'select' => 'js: function(event, ui){
									$("#selcity").val(ui.item.id);
									'.Chtml::ajax(array(
										'type' => 'POST',
										'data' => 'js:({
											city_id : ui.item.id, 
											region_id: $("#selreg").val(), 
											district_id: $("#seldist").val(), 
											OrderId: $("#OrderId").val()
											})',
										'dataType' => 'html',
										'url' => $this->createUrl('/delivery/default/showDeliveryTable'),
										'success' => 'function(data){
											$("#table").html(data);
											$("#table_dop").html("");
										}',
									)).'
								}',
							),
							 'htmlOptions' => array(
								'placeholder'=>'Нас. пункт',
								'class'=>'placeholder',
								'value'=>'Нас. пункт',
								'onfocus'=>'unsetPlaceholder(this);',
								'onblur'=>'setPlaceholder(this);',
							 )
						));
						?>
						<div class="error-text" id="adress_adress_city_id"></div>
					</div>
				</div>
			</div>

			<div class="row clearfix">
				<div class="row-title">Адрес</div>
				<div class="row-elements">
					<div class="col">
						<?php echo CHtml::activeTextField($adress, 'adress_street', array(
							'class'=>'placeholder',
							'placeholder'=>'Улица',
							'value'=>'Улица',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="adress_adress_street"></div>
					</div>
					<div class="col">
						<?php echo CHtml::activeTextField($adress, 'adress_house', array(
							'class'=>'placeholder short',
							'placeholder'=>'№ дома',
							'value'=>'№ дома',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="adress_adress_house"></div>
					</div>
					<div class="col">
						<?php echo CHtml::activeTextField($adress, 'adress_corps', array(
							'class'=>'placeholder short',
							'placeholder'=>'Стр. / корп.',
							'value'=>'Стр. / корп.',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="adress_adress_corps"></div>
					</div>
					<div class="col">
						<?php echo CHtml::activeTextField($adress, 'adress_room', array(
							'class'=>'placeholder short',
							'placeholder'=>'№ квартиры',
							'value'=>'№ квартиры',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="adress_adress_room"></div>
					</div>
				</div>
			</div>

			<div class="row clearfix row-gray">
				<div class="row-title">Дополнительная информация</div>
				<div class="row-elements">
					<div class="col">
						<?php echo CHtml::activeTextField($adress, 'adress_porch', array(
							'class'=>'placeholder short',
							'placeholder'=>'Подъезд',
							'value'=>'Подъезд',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="adress_adress_porch"></div>
					</div>
					<div class="col">
						<?php echo CHtml::activeTextField($adress, 'adress_floor', array(
							'class'=>'placeholder short',
							'placeholder'=>'Этаж',
							'value'=>'Этаж',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="adress_adress_floor"></div>
					</div>
					<br/><br/>
					<div class="col">
						<?php echo CHtml::activeHiddenField($order, 'order_user_id'); ?>
						<?php echo CHtml::activeTextArea($order, 'order_description', array(
							'class'=>'placeholder',
							'placeholder'=>'Комментарии к заказу',
							'value'=>'Комментарии к заказу',
							'onfocus'=>'unsetPlaceholder(this);',
							'onblur'=>'setPlaceholder(this);',
						)); ?>
						<div class="error-text" id="order_order_description"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>

		<div class="subtitle">Способ доставки</div>

		<div class="payment-ways">
			<div class="block-title">Выберите удобный способ доставки</div>
			<div class="clear"></div>
			<div id="table">
			
			</div>
			<div id="table_dop">
				
			</div>	
		</div>



		<div class="bonus">
			<img src="/images/product_bonus_03.png" />
			<p>Гарантия безопасности Ваших покупок!<br/>
				<a href="">Узнать больше</a></p>
		</div>

		<div class="total a-right">
			
			<?php if(0==1 && Yii::app()->shoppingCart->getDiscount()): ?>
			<!--<div class="total-discount">
				<span class="a-right"><span><b>
							<?php echo Yii::app()->shoppingCart->getDiscount(); ?>
						</b></span> руб.</span>
				Ваша скидка составляет:
				
				<div class="clear"></div>
				<?php if(Y::user()->hasState('vaucher')): ?>
					<?php $vaucher = Y::user()->getState('vaucher');?>
					<span>Вы использовали купон: "<?php echo $vaucher['vaucher_code']; ?>"</span>
				<?php else: ?>
					<span>Ваша скидка: "<?php echo Y::user()->getRate()*100; ?>%"</span>
				<?php endif; ?>
			</div>-->
			<?php endif; ?>
			
			<div class="total-price">
				<dl>
					<dd>Предварительный итог:</dd>
					<dt><span><b><?php echo ShopCart::getCost(); ?></b></span> руб. (включая НДС)</dt>
<!--					<dd>Доставка и обработка:</dd>
					<dt><span><b>449</b></span> руб.</dt>-->
				</dl>
			</div>
			<div class="note">
				<dl>
					<dd><span><b>Итого:</b></span></dd>
					<dt><span><b id="totalPrice"><?php echo ShopCart::getCost(); ?></b></span> руб.</dt>
				</dl>
			</div>
		</div>

		<div class="clear"></div>

		<div class="bottom">
			<label><input type="checkbox" checked/> Подписаться на рассылку с информацией об акциях, скидках и новинках магазина</label>
			<a href="javascript:void(0);" class="btn btn-green-medium btn-arrow-right" id="userInfoC"><span><span>Продолжить<img src="/images/arrow_r.png" /></span></span></a>
		</div>

	<?php echo CHtml::endForm(); ?>

</div>

<?php

$js = '
	var dist = "'.$adress->adress_region_id.'";
	$("#userInfoC").bind("click", function(){
	$.ajax({
		dataType: "json",
		type: "post",
		data: $("#userInfo").serialize() + "&" + $("#settings-sel").serialize(),
		success: function(data){
			$(".error-text").html("");
			var url = "";
			if(data.method == "redir")
			{
				window.location = data.url;
				return false;
			}
			if(data.method == "error")
			{
				if(data.user)
				{
					$.each(data.user, function(key, value) {
						$("#user_" + key).html(value);
					});
					url = "#userInfoId";
				}
				if(data.adress)
				{
					$.each(data.adress, function(key, value) {
						$("#adress_" + key).html(value);
					});
					if(!url)
					{
						url = "#infoAdressId";
					}
				}
			}
			if(data.method == "show")
			{
				$("#table_dop").html(data.html);
				url = "#table_dop";
			}
			if(url)
			{
				window.location = url;
			}
			return false;
		}
	});
	return false;
})';

Y::script()->registerScript('userInfo', $js);

?>