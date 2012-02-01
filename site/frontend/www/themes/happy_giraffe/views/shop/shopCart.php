<div id="cart">

	<div class="cart-title">Моя корзина</div>

	<div class="steps">
		<ul>
			<li class="active"><a>Мой заказ</a></li>
			<li><a>Информация</a></li>
			<li><a>Оплата</a></li>
			<li><a>Успешно</a></li>
		</ul>
	</div>

		<div class="cart-items">
			<table>
				<colgroup>
					<col width="220">
					<col>
					<col width="240">
					<col width="100">
					<col width="160">
				</colgroup>
				<thead>
					<tr>
						<td class="col-1">&nbsp;</td>
						<td class="col-2">&nbsp;</td>
						<td class="col-3">&nbsp;</td>
						<td class="col-4">Количество</td>
						<td class="col-5">Сумма</td>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; ?>
					<?php foreach(ShopCart::getItems() as $k=>$position): ?>
                        <?php $product = Product::model()->findByPk($position->id); ?>
					<?php $i++; ?>
					<tr class="<?php echo ($i % 2) ? 'even' : '';?>">
						<td class="col-1">
							<?php echo CHtml::link(
								CHtml::image($product->product_image->getUrl('subproduct'), $product->product_title),
                            $product->getUrl()
							); ?>
						</td>
						<td class="col-2">
							<p><big>
								<?php echo CHtml::link(
									'<b>'.$product->product_title.'</b>',
                                    $product->getUrl()
								); ?>
							</big></p>
<!--				<p>Цвет:  зелено-желтый</p>-->
				<p class="price">
					Цена: <span><b>
							<?php if(intval($product->product_sell_price) || intval(Y::user()->getRate()*100)): ?><strike><?php endif; ?>
								<?php echo $product->product_price; ?>
							<?php if(intval($product->product_sell_price) || intval(Y::user()->getRate()*100)): ?></strike><?php endif; ?>
						</b></span> руб.
					&nbsp;&nbsp;&nbsp;
					
					<?php if(intval($product->product_sell_price)): ?>
						<img src="/images/shock-price-cart.png"> <span class="discounted"><b><?php echo $product->product_sell_price; ?></b></span> руб.</p>
				
					<?php else: ?>
						<?php if(intval(Y::user()->getRate()*100)): ?>
						<img src="/images/product_price_discount_img.png"> <span class="discounted"><b><?php echo intval((1-Y::user()->getRate())*$product->product_price); ?></b></span> руб.</p>
				
						<?php endif; ?>
				
					<?php endif; ?>
				
				</td>
				<td class="col-3">
<!--					<a class="hold" href="">Отложить</a>-->
					<?php echo CHtml::link('Удалить',array(
						'remove',
						'sid'=>$position->primaryKey,
					), array(
						'class'=>'remove',
					)); ?>
				</td>
				<td class="col-4">
					<div class="counter">
						<?php echo CHtml::link('', array(
							'putIn',
							'id' => $position->primaryKey,
							'count' => -1),
						array(
							'class'=>'dec',
                            'onclick' => "updateCount(this, '".$position->primaryKey."', -1);return false;"
						)); ?>
						<input readonly type="text" value="<?php echo $position->count; ?>">
						<?php echo CHtml::link('', array(
							'putIn',
							'id' => $position->primaryKey,
							'count' => 1),
						array(
							'class'=>'inc',
                            'onclick' => "updateCount(this, '".$position->primaryKey."', 1);return false;"
						)); ?>
					</div>
				</td>
				<td class="col-5"><span><span class="item_price"><?php echo $position->getSumPrice(); ?></span> руб.</span></td>
				</tr>
				<?php endforeach; ?>

				</tbody>						
			</table>
		</div>

		
	<?php if(!Y::user()->hasState('vaucher')): ?>
		<?php
		echo CHtml::beginForm(array('/shop/useVaucher'), 'get', array(
			'id' => 'useVaucherForm',
		));

		$js = '
		var sURL = unescape(window.location.pathname);
		
		$("#useVaucherForm").submit(function(){
			$.ajax({
				url: $(this).attr("action"),
				dataType: "json",
				data: {code:$("#code").val()},
				success: function(msg){
					if(msg.msg == "Ok")
					{
						window.location = sURL;
					}else{
						alert(msg.msg);
					}
				}
			});
			return false;
		})';
		Y::script()->registerScript('useVaucherForm', $js);
		?>
		<div class="promo-code a-right">
			<div class="inputs">
				<?php echo CHtml::textField('code', '', array(
					'placeholder'=>'Введите промо-код',
				)); ?>
				<button class="btn btn-orange"><span><span>Использовать</span></span></button>
			</div>
			<span>Введите код купона, если он у Вас есть</span>
		</div>
		<?php echo CHtml::endForm(); ?>
	<?php endif; ?>

		<div class="bonus">
			<img src="/images/product_bonus_03.png">
			<p>Гарантия безопасности Ваших покупок!<br>
				<a href="#">Узнать больше</a></p>
		</div>

		<div class="clear"></div>

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
				<span class="a-right"><span><b>
					<?php echo ShopCart::getCost(); ?>
				</b></span> руб.</span>
				Предварительный итог:
			</div>
			<div class="note">Точная сумма с доставкой  будет рассчитана позднее.</div>
		</div>

		<div class="clear"></div>

		<div class="bottom">
			<a class="btn btn-orange btn-arrow-left" href="/shop/"><span><span><img src="/images/arrow_l.png"><b>Вернуться в магазин</b></span></span></a>
			<?php echo CHtml::link('<span><span>Оформить заказ<img src="/images/arrow_r.png"></span></span>', array('order/create'), array(
				'id' => 'checkout',
				'class'=>'btn btn-green-medium btn-arrow-right fancy',
				'class'=>'btn btn-green-medium btn-arrow-right',
			)); ?>
		</div>
</div>
    <script type="text/javascript">
        function updateCount(elem, id, value) {
            var count = $(elem).siblings('input').val();
            if(parseInt(count) + value <= 0)
                return false;
            var url = '<?php echo $this->createUrl('/shop/putInAjax/'); ?>?count=' + value + '&id=' + id;
            $.get(
                url,
                {},
                function(data) {
                    $(elem).siblings('input').val(data.itemCount);
                    $(elem).parents('tr:eq(0)').find('.item_price').text(data.itemCost);
                    $('.fast-cart span.count').text(data.count);
                },
                'json'
            )
        }
    </script>