<li>
	<div class="img-box"><?php echo CHtml::link(CHtml::image($data->product_image->getUrl('subproduct'), $data->product_title), array('product/view', 'id' => $data->product_id)); ?></div>
	<div class="item-title"><?php echo CHtml::link($data->product_title, array('product/view', 'id' => $data->product_id)); ?></div>
	<div class="rating rating-5"></div>
	<div class="item-price">
		<div class="col">Цена: <span><b><?php echo ($data->product_sell_price == 0) ? $data->product_price : CHtml::tag('strike', array(), $data->product_price); ?></b></span> руб.</div>
		<?php if ($data->product_sell_price != 0): ?><img src="/images/product_price_discount_img.png"> <span class="discounted"><b><?php echo $data->product_sell_price; ?></b></span> руб.<?php endif; ?>
	</div>
	<div class="controls">
		<div class="counter"><a class="dec"></a><input type="text" value="0" /><a class="inc"></a></div>
		<a href="" class="btn btn-green-small"><span><span>В КОРЗИНУ</span></span></a>
		<a href="" class="to-wish-list"></a>
	</div>
	<div class="bonus">
		<img src="/images/img_free_shipping.png" /> Доставка бесплатно
	</div>
</li>