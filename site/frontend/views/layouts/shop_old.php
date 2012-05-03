<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>
	<?php echo CHtml::metaTag('text/html; charset=utf-8', NULL, 'Content-Type'); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/common.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/ie.css', 'screen'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/store.css'); ?>
	
	
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js'); ?>
	
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.jcarousel.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.placeholder.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/chosen.jquery.min.js'); ?>

	<script type="text/javascript">
	
		$(document).ready(function(){
			if ($('.jcarousel').size() > 0) {
				$('.jcarousel').each(function(){
					
					$(this).bind('jcarouselscrollend', function(carousel) {
						
						$(this).parent().find('.prev').removeClass('disabled');
						$(this).parent().find('.next').removeClass('disabled');
						
						if ($(this).find('li:first').is('.jcarousel-item-fullyvisible')) {
							$(this).parent().find('.prev').addClass('disabled');
						}
						
						if ($(this).find('li:last').is('.jcarousel-item-fullyvisible')) {
							$(this).parent().find('.next').addClass('disabled');
						}

					});			
					
				})		
			}
			
			$('#product-thumbs').jcarousel();
			
			$('#else-products-slider').jcarousel({
				vertical: true
			});
		})
		
	</script>
	
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/common.js'); ?>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27545132-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>
<body class="body-store">
	<div id="layout" class="wrapper">
		
		<div class="clearfix" id="header">
			
			<div class="logo-box">
				<a class="logo" href="/"></a>
			</div>
			
			<div class="header-in">
								
				<div class="search-box">
					<button class="btn"><span><span>Поиск</span></span></button>
					<div class="text">
						<input type="text"/>
					</div>
				</div>
				
                <?php $this->widget('site.frontend.widgets.loginWidget.LoginWidget'); ?>
				
				<div class="nav">
					<ul>
						<li class="green">
							<?php echo CHtml::link('<span>Товар</span>', array(
								'product/view',
								'id'=>10,
								'title'=>'Jetem_Turbo_4S',
							)); ?>
						</li>
						<li class="yellow">
							<?php echo CHtml::link('<span>Каталог</span>', array(
								'category/view',
								'id'=>7,
							)); ?>
						</li>
					</ul>
				</div>
				
				<div class="fast-cart">
					<?php echo CHtml::link('Моя корзина', array('shop/shopCart')); ?>
					<div class="in">
						<span class="count"><?php echo ShopCart::getItemsCount(); ?></span>
						&nbsp;
						<?php echo CHtml::link('товара', array('shop/shopCart')); ?>
						&nbsp;&nbsp;
						<?php echo CHtml::link('<span><span>Оформить<img src="/images/arr_r_small.png"></span></span>', array(
							'/shop/shopCart'
						), array(
							'class' => 'btn btn-orange-small btn-arrow-right',
						)); ?>
					</div>
				</div>
				
			</div>
			
		</div>
		
<!--		<div id="header" class="clearfix">
			
			<div class="logo-box">
				<a href="" class="logo"></a>
			</div>
			
			<div class="header-in">
				
				<div class="login-box">
					<?php if (Yii::app()->user->isGuest): ?>
						<span class="lk">Личный кабинет</span>
						<?php echo CHtml::link('Вход', '#login', array('class' => 'fancy')); ?>
						|
						<?php echo CHtml::link('Регистрация', Yii::app()->createUrl('../club/signup')); ?>
					<?php else: ?>
						<span class="welcome"><b>Добро пожаловать,</b> <a href="<?php echo CController::createUrl('../shop/profile/index'); ?>"><?php echo Yii::app()->user->first_name; ?><?php if (Yii::app()->user->last_name) echo ' ' . Yii::app()->user->last_name; ?>!</a></span>
						<?php echo CHtml::link('Выход', Yii::app()->createUrl('../club/site/logout')); ?>
					<?php endif; ?>
				</div>
				
				<div class="search-box">
					<button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
					<div class="text">
						<input type="text" />
					</div>
				</div>
				
			</div>
			
		</div>-->
		
<!--		<div id="nav" class="clearfix">
			<ul class="clearfix">
				<li class="drp">
					<?php echo CHtml::link('<span>Категории</span>', array(
						'/category'
					), array(
						'style'=>'background-color:#ac89ce;',
					)); ?>
				</li>
				<li class="drp">
					<?php echo CHtml::link('<span>Возраст и пол</span>', array(
						'/category/ages'
					), array(
						'style'=>'background-color:#f89731;',
					)); ?>
				</li>
				<li class="drp">
					<?php echo CHtml::link('<span>Бренд</span>', array(
						'/category/brands'
					), array(
						'style'=>'background-color:#67bd51;',
					)); ?>
				</li>
				<li>
					<?php echo CHtml::link('<span>Новинки</span>', array(
						'/category/new'
					), array(
						'style'=>'background-color:#41b3cc;',
					)); ?>
				</li>
				<li class="sales"><a href="" style="background-color:#fad84a;"><span>Акции</span></a></li>
			</ul>
			<div class="fast-cart">
				<div class="in">
					<span class="count"><?php echo Yii::app()->shoppingCart->getItemsCount(); ?></span>
					&nbsp;
					<a href="">товара</a>
					&nbsp;&nbsp;
					<?php echo CHtml::link('<span><span>Оформить</span></span>', array(
						'/shop/shopCart'
					), array(
						'class' => 'btn btn-blue-arrow-small',
					)); ?>
				</div>
			</div>
		</div>-->
		
		<?php
			/*$this->widget('zii.widgets.CBreadcrumbs', array(
			    'separator' => ' &nbsp;>&nbsp; ',
			    'encodeLabel' => false,
			    'links'=>$this->breadcrumbs,
			    'htmlOptions' => array(
				'class' => null,
				'id' => 'crumbs',
			    ),
			));*/
		?>
		
		<div id="content" class="clearfix">
			
			<?php echo $content; ?>
			
		</div>
		
		<div class="push"></div>
	</div>
	<div id="footer" class="wrapper">
		&nbsp;
	</div>
	
	<!-- Yandex.Metrika counter -->
	<div style="display:none;"><script type="text/javascript">
	(function(w, c) {
	    (w[c] = w[c] || []).push(function() {
		try {
		    w.yaCounter11221648 = new Ya.Metrika({id:11221648, enableAll: true});
		}
		catch(e) { }
	    });
	})(window, "yandex_metrika_callbacks");
	</script></div>
	<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
	<noscript><div><img src="//mc.yandex.ru/watch/11221648" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
</body>
</html>