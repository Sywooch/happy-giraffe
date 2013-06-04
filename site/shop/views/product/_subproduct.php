<li>
	<div class="img-box"><?php echo CHtml::link(CHtml::image($sp->product_image->getUrl('subproduct'), $sp->product_title), $sp->getUrl()); ?></div>
	<div class="item-title"><?php echo CHtml::link($sp->product_title, $sp->getUrl()); ?></div>
	<?php $this->renderPartial('rating', array('rating' => $sp->product_rate)); ?>
	
	<div class="item-price">
			Цена: 
			<?php if(intval($sp->product_sell_price) || intval(Y::user()->getRate()*100)): ?>
				<span><b><strike><?php echo intval($sp->product_price); ?></strike></b></span> руб.
				&nbsp;&nbsp;&nbsp;&nbsp;
				<?php if(intval($sp->product_sell_price)): ?>
					<img src="/images/shock-price-cart.png">
					<span class="discounted"><b><?php echo intval($sp->product_sell_price); ?></b></span> руб.
				<?php else: ?>
					<img src="/images/product_price_discount_img.png">
					<span class="discounted"><b><?php echo intval((1-Y::user()->getRate())*$sp->product_price); ?></b></span> руб.
				<?php endif; ?>
			<?php else:?>
				<span><b><?php echo intval($sp->product_price); ?></b></span> руб.
			<?php endif; ?>
			
	</div>
	
	<div class="controls">
		<div class="counter">
			<a class="dec" onclick="decL(this)"></a>
			<input readonly type="text" value="1" />
			<a class="inc" onclick="incL(this)"></a>
		</div>
		<?php echo CHtml::link('<span><span>В КОРЗИНУ</span></span>', array(
			'shop/putIn',
			'id'=>$sp->product_id,
			'count'=>1,
			),array(
			'class'=>'btn btn-green-small fancy',
		)); ?>
		<a href="" class="to-wish-list"></a>
	</div>
</li>