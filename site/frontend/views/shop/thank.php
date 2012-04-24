<div id="cart">

	<div class="cart-title">Моя корзина</div>

	<div class="steps">
		<ul>
			<li><a>Мой заказ</a></li>
			<li><a>Информация</a></li>
			<li><a>Оплата</a></li>
			<li class="active"><a>Успешно</a></li>
		</ul>
	</div>

	<div class="highlight success">

		<div class="success-title">Спасибо за покупку!</div>

		<span class="order-num">Номер Вашего заказа <span><?php echo $order_id; ?></span></span>

		<p>В течении 24 часов с Вами свяжется менеджер нашего интернет-магазина.</p>

		<?php if(Yii::app()->getModule('billing')->getPsByOrder($order_id)=='BANK'): ?>
			<p class="note">Оплата по данному заказу производится через отделения Сбербанка РФ. Квитанцию для оплаты
				Вы можете распечатать по адресу 
				<?php echo CHtml::link('Заказ №'.$order_id, Yii::app()->getModule('billing')->getPrintUrlByOrder($order_id), array(
					'target'=>'_blank',
				)); ?>. &nbsp; 
				<?php echo CHtml::link('Распечатать', Yii::app()->getModule('billing')->getPrintUrlByOrder($order_id), array(
					'class'=>'download',
					'target'=>'_blank',
				)); ?><br>
				Формирование заказа начнется после поступления на расчетный счет нашего интернет-магазина 
				денежных средств в размере, указанном в настоящем заказе (100% предоплата).</p>

			<p>Вы получите письмо на Ваш адрес электронной почты (e-mail) с подробной информацией
				о заказе и ссылкой на страницу, на которой можно проверить текущий статус заказа. </p>
		<?php endif; ?>

	</div>

</div>