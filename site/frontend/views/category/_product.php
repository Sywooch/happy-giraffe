<?php

$js = "function incA(el, id) {
	var input = $(el).prev();
	var old_val = parseInt(input.val());
	input.val(old_val + 1);
	".CHtml::ajax(array(
		'url'=>array('shop/putInAjax'),
		'data'=>'js:{count:1,id:id}',
		'dataType'=>'json',
			'success'=>'js:function(msg){
				$("#itemSCount").html(msg.count);
				$("#itemSCost").html(msg.cost);
				$(".fast-cart span.count").text(msg.count);
			}',
	))."
};
function decA(el, id) {
	var input = $(el).next();
	var old_val = parseInt(input.val());
	if (old_val > 0)
	{
		input.val(parseInt(input.val()) - 1);
		".CHtml::ajax(array(
			'url'=>array('shop/putInAjax'),
			'data'=>'js:{count:-1,id:id}',
			'dataType'=>'json',
			'success'=>'js:function(msg){
				$("#itemSCount").html(msg.count);
				$("#itemSCost").html(msg.cost);
				$(".fast-cart span.count").text(msg.count);
			}',
		))."
	}
}

function incL(el)
{
	var input = $(el).prev();
	var old_val = parseInt(input.val());
	
	input.val(old_val + 1);

	var re = $(el).parent().parent();
	var link = re.children('.fancy');
	var href = link.attr('href');
	
	var nhref = href.replace(/count=\d+/,'count=' + (old_val + 1));
	link.attr('href',nhref);
}

function decL(el)
{
	var input = $(el).next();
	var old_val = parseInt(input.val());
	
	if(old_val > 1)
	{
		input.val(old_val - 1);
		
		var re = $(el).parent().parent();
		var link = re.children('.fancy');
		var href = link.attr('href');

		var nhref = href.replace(/count=\d+/,'count=' + (old_val - 1));
		link.attr('href',nhref);
	}
};";

Y::script()->registerScript('incDec', $js, CClientScript::POS_HEAD);

; ?>
<li>
	<div class="img-box"><?php if($sp->main_image) echo CHtml::link(CHtml::image($sp->main_image->photo->getPreviewUrl(160, 160, Image::WIDTH, true), $sp->product_title), $sp->getUrl()); ?><?php if (intval($sp->product_sell_price)): ?><label><img src="/images/product_price_discount_img_shock_big.png" /></label><?php endif; ?></div>
	<div class="item-title"><?php echo CHtml::link($sp->product_title, $sp->getUrl()); ?></div>
	<div class="rating rating-<?php echo intval($sp->product_rate);?>"></div>
	<div class="item-price">
		<?php if(intval($sp->product_sell_price) || intval(Y::user()->getRate()*100)): ?>
		<div class="col">Цена: <span><b><strike><?php echo intval($sp->product_price); ?></strike></b></span> руб.</div>
		<?php else:?>
		<div class="col">Цена: <span><b><?php echo intval($sp->product_price); ?></b></span> руб.</div>
		<?php endif; ?>
		<?php if(intval($sp->product_sell_price)): ?>
		<img src="/images/shock-price-cart.png" alt="Sh">
		<span class="discounted"><b><?php echo intval($sp->product_sell_price); ?></b></span>
		руб.
		<?php else:?>
			<?php if(intval(Y::user()->getRate()*100)): ?>
			<img src="/images/product_price_discount_img.png">
			<span class="discounted"><b><?php echo intval((1-Y::user()->getRate())*$sp->product_price); ?></b></span>
			руб.
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="controls">
		<div class="counter">
			<a class="dec" onclick="decL(this)"></a>
			<input readonly type="text" value="1" />
			<a class="inc" onclick="incL(this)"></a>
		</div>

		<?php
		echo CHtml::link('<span><span>В КОРЗИНУ</span></span>', array(
			'shop/putIn',
			'id' => $sp->product_id,
			'count' => 1,
			), array(
			'class' => 'btn btn-green-small fancy',
		));
		?>

		<!--								<a href="" class="to-wish-list"></a>-->
	</div>
	<div class="bonus">
		<img src="/images/img_free_shipping.png" /> Доставка бесплатно
	</div>
</li>