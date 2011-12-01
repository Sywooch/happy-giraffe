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
			}',
		))."
	}
};

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
}
";

Y::script()->registerScript('incDec', $js, CClientScript::POS_HEAD);

	$cs = Yii::app()->clientScript;
	$js = "	
$('button.cancel').live('click', function(e) {
	e.preventDefault();
	ProductComment_text_redactor.setHtml('<p>&nbsp;</p>');
});

$('div.comments ul:first li:gt(2)').hide();
$('div.comments div.all a').live('click', function (e) {
	e.preventDefault();
	var lastShown = $('div.comments ul:first li:visible').length;
	$('div.comments ul:first li:hidden:lt(10)').show();
	$('html,body').animate({scrollTop: $('div.comments ul:first li:eq(' + lastShown + ')').offset().top},'slow',function() {
		$('div.comments ul:first li:first').fadeIn(1000);
	});
	if ($('div.comments ul:first li:hidden').length == 0)
	{
		$('div.comments div.all').hide();
	}
});

$('#add_comment').live('submit', function(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		data: $(this).serialize(),
		dataType: 'json',
		url: " . CJSON::encode(Yii::app()->createUrl('product/sendcomment')) . ",
		success: function(response) {
			if (response.status == 'ok')
			{
				var lastShown = $('div.comments ul:first li:visible').length - 1;
				if (lastShown < 2) lastShown = 2;
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {
						product_id: $('#ProductComment_product_id').val()
					},
					url: " . CJSON::encode(Yii::app()->createUrl('product/showcomments')) . ",
					success: function(response) {
						$('div.comments div.add').hide();
						$('div.comment-count').text(response.total);
						$('#comments_list').html(response.list);
						$('span.product_rate').html(response.rating);
						$('div.comments ul:first li:gt(' + lastShown + ')').hide();
						$('div.comments ul:first li:first').hide();
						$('html,body').animate({scrollTop: $('.steps-comments').offset().top},'slow',function() {
							$('div.comments ul:first li:first').fadeIn(1000);
						});
					}
				});
				ProductComment_text_redactor.setHtml('<p>&nbsp;</p>');
			}
		},
	});
});
	";
	$cs
	 ->registerScript('product_comment', $js)
	 ->registerCssFile('/stylesheets/cloud-zoom.css')
	 ->registerScriptFile('/javascripts/cloud-zoom.1.0.2.min.js');
	
?>
<div class="content-box clearfix">
	<div class="main">					
			
		<div id="product">
			
			
			<div class="description clearfix">
				
				<div class="description-img">
					
					<div class="img-in">
						<?php echo CHtml::link(CHtml::image($model->product_image->getUrl('product'), $model->product_title), $model->product_image->getUrl('original'), array(
							'class' => 'cloud-zoom',
							'id' => 'zoom1',
							'rel' => 'adjustX: 40, adjustY:-4',
						)); ?>
					</div>
					
					<div class="img-thumbs" class="jcarousel-container">
						<div id="product-thumbs" class="jcarousel">
							<?php
								$imagesDP = $images->search($criteriaImage);
							?>
							<ul>
								<li>
									<?php echo CHtml::link(CHtml::image($model->product_image->getUrl('product_thumb'), $model->product_title), $model->product_image->getUrl('original'), array(
										'class' => 'cloud-zoom-gallery',
										'rel' => 'useZoom: "zoom1", smallImage: "' . $model->product_image->getUrl('product') . '"',
									)); ?>
								</li>
								<?php foreach ($imagesDP->data as $i): ?>
									<li>
										<?php echo CHtml::link(CHtml::image($i->image_file->getUrl('product_thumb'), $model->product_title), $i->image_file->getUrl('original'), array(
											'class' => 'cloud-zoom-gallery',
											'rel' => 'useZoom: "zoom1", smallImage: "' . $i->image_file->getUrl('product') . '"',
										)); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<a href="javascript:void(0);" class="jcarousel-prev prev disabled" onclick="$('#product-thumbs').jcarousel('scroll', '-=1');"></a>
						<a href="javascript:void(0);" class="jcarousel-next next" onclick="$('#product-thumbs').jcarousel('scroll', '+=1');"></a>
						
					</div>
					
<!--					<div class="color-list">
						<span>Цвет:</span>
						<ul>
							<li><a href=""><img src="/images/product_color_01.png" /></a></li>
							<li><a href=""><img src="/images/product_color_02.png" /></a></li>
							<li><a href=""><img src="/images/product_color_03.png" /></a></li>
							<li><a href=""><img src="/images/product_color_04.png" /></a></li>
							<li><a href=""><img src="/images/product_color_05.png" /></a></li>
							<li><a href=""><img src="/images/product_color_06.png" /></a></li>
						</ul>
					</div>-->
					
				</div>
				
				<div class="description-text">
					
					<h1><?php echo $model->product_title; ?></h1>
					
					<?php if($model->brand): ?>
					<p class="producer">
						<span style="vertical-align: top;padding: 5px;">
							Производитель:
						</span>
						<?php echo CHtml::image($model->brand->brand_image->getUrl(), $model->brand->brand_title); ?>
					</p>
					<?php endif; ?>
					
					<span class="product_rate"><?php $this->renderPartial('rating', array('rating' => $model->product_rate)); ?></span>
					
					<p><?php echo nl2br($model->product_text); ?></p>
					
				</div>
				
			</div>
			
			<div class="price-box clearfix">
				
				<div class="col price">
					Стоимость товара:
					
					<?php if (intval($model->product_sell_price) || intval(Y::user()->getRate()*100)): ?>
					<span><strike><?php echo intval($model->product_price); ?></strike><span>руб.</span></span>
					<?php else: ?>
					<span><?php echo intval($model->product_price); ?><span>руб.</span></span>
					<?php endif; ?>
					
				</div>
				
				<?php if (intval($model->product_sell_price)): ?>
				<div class="col discount">
					<img src="/images/shock-price-product.png" />
					<span><?php echo intval($model->product_sell_price); ?><span>руб.</span></span>
					<div class="economy">Экономия: <b><?php echo intval($model->product_price - $model->product_sell_price); ?></b> руб.</div>
				</div>	
				<?php else: ?>
					<?php if(intval(Y::user()->getRate()*100)): ?>
					<div class="col discount">
						С Вашей скидкой - <img src="/images/product_price_discount_img.png" />
						<span><?php echo intval((1-Y::user()->getRate())*$model->product_price); ?><span>руб.</span></span>
						<div class="economy">Экономия: <b><?php echo intval($model->product_price) - intval((1-Y::user()->getRate())*$model->product_price); ?></b> руб.</div>
					</div>	
					<?php endif; ?>
				<?php endif; ?>
				
				<div class="col to-cart">
					Количество: <div class="counter">
						<a class="dec" onclick="decL(this)"></a>
						<input readonly type="text" value="1" />
						<a class="inc" onclick="incL(this)"></a>
					</div>
					<br/>
					<?php echo CHtml::link('<span><span>В КОРЗИНУ</span></span>', array(
						'shop/putIn',
						'id'=>$model->product_id,
						'count'=>1,
						),array(
						'class'=>'btn btn-green-medium fancy',
					)); ?>
					<button class="btn btn-yellow-medium btn-wish-list"><span><span>В список желаний <img src="/images/img_wish_list.png" /></span></span></button>
				</div>
				
			</div>
			
			<div class="bonuses-box clearfix">
				<div class="bonus">
					<img src="/images/product_bonus_01.png" />
					<div class="in">
						Бесплатная доставка <a href="">Условия доставки</a><br/>
						<small>(при заказе от 5 000 руб.)</small>
					</div>
				</div>
				<div class="bonus">
					<img src="/images/product_bonus_02.png" />
					<div class="in">
						Гарантированный подарок <a href="">Узнай какой</a>
					</div>
				</div>
				
			</div>
			
			<div class="tabs">
				<div class="steps">
					<ul>
						<li class="active"><a href="javascript:void(0);" onclick="setTab(this, 1);"><span>Тех. характеристика</span></a></li>
						<?php if ($model->videos): ?><li><a href="javascript:void(0);" onclick="setTab(this, 2);"><span>Видео о товаре</span></a></li><?php endif; ?>
<!--						<li><a href="javascript:void(0);" onclick="setTab(this, 3);"><span>Доп. информация</span></a></li>-->
					</ul>
				</div>
				<div class="tab-box tab-box-1" style="display:block;">
					<div class="tech">
						<ul>
							<?php $attributes = $model->getAttributesText(); ?>
							<li>
								<ul>
									<?php $i = 0; foreach ($attributes as $a): ?>
										<?php if (++$i % 2 == 1): ?>
											<li><span class="a-right"><?php echo $a['eav_attribute_value']; ?></span><span><?php echo $a['attribute_title']; ?></span></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</li>
							<li>
								<ul>
									<?php $i = 0; foreach ($attributes as $a): ?>
										<?php if (++$i % 2 == 0): ?>
											<li><span class="a-right"><?php echo $a['eav_attribute_value']; ?></span><span><?php echo $a['attribute_title']; ?></span></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</li>
							
						</ul>
					</div>
				</div>
				<?php if ($model->videos): ?>
					<div class="tab-box tab-box-2">
						<div class="videos clearfix">
							<ul>
								<?php foreach ($model->videos as $v): ?>
									<li>
										<div class="title-box">
											<?php echo CHtml::link($v->title, $v->url, array(
												'target'=>'_blank',
											));?>
										</div>
										<div class="img-box">
											<?php echo CHtml::link(CHtml::image($v->preview, $v->title), $v->url, array(
												'target'=>'_blank',
											)); ?>
										</div>
									</li>
								<?php endforeach; ?>						
							</ul>
						</div>
					</div>
				<?php endif; ?>
<!--				<div class="tab-box tab-box-3">
					<div class="text-block">
						<big>Коляска Hartan Sky</big>
						<ul>
							<li>Основное отличие - колеса иммитация.</li>
							<li>Коляска <b>Hartan Sky</b> подходит для детей от рождения и до 3 лет, имеет широкую люльку с удобными крепкими ручками для переноски. Высота ручки регулируется в нескольких положениях и к тому же является перекидной, что дает возможность вести малыша в коляске, как лицом к родителям, так и лицом вперед.</li>
							<li>Наклон спинки сидения прогулочного блока регулируется в трех положениях ( почти до горизонтального). </li>
							<li>Ширина места для сидения прогулочного блока - 32 см, глубина (с опущеной подножкой) - 30см.</li>
							<li>Для обеспечения безопасности предусмотрены 5-и точечные ремни.</li>
							<li>Диаметр колес: 28см.</li>
							<li>Ширина колесной базы: 62 см, что позволяет без труда входить с в любой лифт.</li>
							<li>Подножка коляски регулируемая: можно изменить как угол наклона, так и увеличить её длину.</li>
							<li>В комплекте: москитная сетка, чехол на ноги.</li>
						</ul>
					</div>
				</div>-->
			</div>
			
			<div class="steps steps-comments">
				<?php if(! Yii::app()->user->isGuest && ! $model->rated(Yii::app()->user->id)): ?>
					<a href="#add_comment" class="btn btn-orange a-right"><span><span>Добавить отзыв</span></span></a>
				<?php endif; ?>
				<ul>
					<li class="active"><a>Отзывы о товаре</a></li>
				</ul>
				<div class="comment-count"><?php echo count($comments); ?></div>
				<div class="avg-rating">
					Средняя оценка:  <span class="product_rate"><?php $this->renderPartial('rating', array('rating' => $model->product_rate)); ?></span>
				</div>
			</div>
			<div class="comments">
				<div id="comments_list"><?php $this->renderPartial('list', array('comments' => $comments)); ?></div>						
				<?php if(! Yii::app()->user->isGuest && ! $model->rated(Yii::app()->user->id)): ?>
					<div class="add clearfix">
						<div class="new-comment">
							<?php $form = $this->beginWidget('CActiveForm', array(
								'id' => 'add_comment',
							)); ?>
								<?php echo $form->hiddenField($comment_model, 'product_id', array('value' => $model->product_id)); ?>
								<span>Ваша оценка:</span>
								<div class="rating setRating" onmouseout="setRatingOut(this);">
									<span onmouseover="setRatingHover(this, 1);" onclick="setRating(this,1);"></span>
									<span onmouseover="setRatingHover(this, 2);" onclick="setRating(this,2);"></span>
									<span onmouseover="setRatingHover(this, 3);" onclick="setRating(this,3);"></span>
									<span onmouseover="setRatingHover(this, 4);" onclick="setRating(this,4);"></span>
									<span onmouseover="setRatingHover(this, 5);" onclick="setRating(this,5);"></span>
									<?php echo $form->hiddenField($comment_model, 'rating'); ?>
								</div>
								<br/>
								<?php
									$this->widget('ext.imperaviRedactor.EImperaviRedactorWidget', array(
										'model' => $comment_model,
										'attribute' => 'text',
										'options' => array(
											'toolbar' => 'main',
										),
										'htmlOptions' => array(
											'rows' => 5,
											'value' => '',
										),
									));
								?>
								<button class="btn btn-gray-medium cancel"><span><span>Отменить</span></span></button>
								<button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
							<?php $this->endWidget(); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			
		</div>
		
	</div>
	
	<div class="side-right">
		<?php $subProductsDP = $subProducts->search($criteriaSubProduct);
			if ($subProductsDP->data): ?>
			<div class="buy-else">
				
				<div class="buy-else-title">Купить с этим товаром</div>
			
				<div class="jcarousel-container product-list">
					<div id="else-products-slider" class="jcarousel jcarousel-vertical">
						<ul>
							<?php foreach ($subProductsDP->data as $sp): ?>
								<?php
								$this->renderPartial('_subproduct', array(
									'sp'=>$sp,
								));
								?>
							<?php endforeach; ?>
						</ul>
					</div>
					<a href="javascript:void(0);" class="jcarousel-prev prev disabled" onclick="$('#else-products-slider').jcarousel('scroll', '-=1');"></a>
					<a href="javascript:void(0);" class="jcarousel-next next" onclick="$('#else-products-slider').jcarousel('scroll', '+=1');"></a>
				</div>
			
			</div>
		<?php endif; ?>
		
	</div>

</div>

<!--<div class="b-banners">
	<ul>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
	</ul>
</div>-->