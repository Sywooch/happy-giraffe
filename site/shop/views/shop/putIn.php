<div id="productAdded" class="popup">
	<a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>
	<div class="product-info clearfix">
		<div class="img-box">
			<?php echo CHtml::image($model->product_image->getUrl('subproduct'), $model->product_title); ?>
		</div>
		<div class="in">
			В Вашу корзину добавлен товар: 
			<span class="product-name">
				<?php echo CHtml::link('<b>'.$model->product_title.'</b>', $model->getUrl()); ?>
			</span>
			<div class="counter">
				<a class="dec" onclick="decA(this, '<?php echo $cart->primaryKey;?>');return false;"></a>
				<input readonly type="text" value="<?php echo $cart->count; ?>" />
				<a class="inc" onclick="incA(this, '<?php echo $cart->primaryKey;?>');return false;"></a> шт.
			</div>
		</div>
	</div>
	<div class="in">
		В Вашей корзине <big><b id="itemSCount"><?php echo ShopCart::getItemsCount(); ?></b></big> товара
		<div class="total-price">
			<span class="a-right"><span><b id="itemSCost"><?php echo ShopCart::getCost(); ?></b></span> руб.</span>
			Предварительный итог:
		</div>
		<div class="note">Точная сумма с доставкой  будет рассчитана позднее.</div>
	</div>
	<div class="bottom">
		<a href="javascript:void(0);" onclick="$.fancybox.close();" class="btn btn-orange btn-arrow-left"><span><span><img src="/images/arrow_l.png" /><b>Вернуться в магазин</b></span></span></a>
		<?php echo CHtml::link(
				'<span><span>Оформить заказ<img src="/images/arrow_r.png" /></span></span>', 
				array('/shop/shopCart'), 
				array('class' => 'btn btn-green-medium btn-arrow-right')); 
		?>
	</div>
</div>