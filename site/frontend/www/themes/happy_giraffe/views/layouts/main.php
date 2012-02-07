<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#">
<head>
	<?php echo CHtml::metaTag('text/html; charset=utf-8', NULL, 'Content-Type'); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php //Yii::app()->clientScript->registerCssFile('/stylesheets/wym.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/global.css?r=112'); ?>
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/common.css?r=112'); ?>
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css?r=112'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/cusel.css?r=112'); ?>
	
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/cusel.js?r=111'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/checkbox.js?r=111'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js'); ?>
	
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/common.js?r=112'); ?>

	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/ie.css?r=112', 'screen'); ?>
	
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.iframe-post-form.js'); ?>

	<?php
		$reports = "
$('.report-block .cancel').live('click', function() {
	$(this).parents('.report-block').remove();
	return false;
});
$('.report-form').live('submit', function() {
	var report_block = $(this).parents('.report-block');
	$.ajax({
		type: 'POST',
		data: $(this).serialize(),
		url: " . CJSON::encode($this->createUrl('/ajax/acceptreport')) . ",
		success: function(response) {
			report_block.remove();
		}
	});
	return false;
});
function report(item)
{
	if (item.next().attr('class') != 'report-block')
	{
		var source_data = item.attr('id').split('_');
		$.ajax({
			type: 'POST',
			data: {
				source_data: {
					model: source_data[0],
					object_id: source_data[1],
				}
			},
			url: " . CJSON::encode($this->createUrl('/ajax/showreport')) . ",
			success: function(response) {
				item.after(response);
			}
		});
	}
	else
	{
		item.next().remove();
	}

}
		";
		Yii::app()->clientScript->registerScript('reports', $reports);
	?>
	
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
<body class="body-club">
	<div class="page">
	
		<div id="header" class="clearfix">
			
			<div class="logo-box">
				<a href="/" class="logo"></a>
			</div>
			
			<div class="header-in">
								
				<div class="search-box">
					<button class="btn"><span><span>Поиск</span></span></button>
					<div class="text">
						<input type="text" />
					</div>
				</div>
				
				<div class="login-box">
					<?php if (Yii::app()->user->isGuest): ?>
						<span class="lk">Личный кабинет</span>
						<?php echo CHtml::link('Вход', '#login', array('class' => 'fancy')); ?>
						|
						<?php echo CHtml::link('Регистрация', Yii::app()->createUrl('signup')); ?>
					<?php else: ?>
						<span class="welcome"><b>Добро пожаловать,</b> <a href="<?php echo Yii::app()->createUrl('profile/index'); ?>"><?php echo Yii::app()->user->first_name; ?><?php if (Yii::app()->user->last_name) echo ' ' . Yii::app()->user->last_name; ?>!</a></span>
						<?php echo CHtml::link('Выход', Yii::app()->createUrl('site/logout')); ?>
					<?php endif; ?>
				</div>
				
				<div class="nav">
					<?php 
						$this->widget('zii.widgets.CMenu', array(
							'encodeLabel' => false,
							'items' => array(
								array(
									'label' => '<span>Клубы</span>',
									'url' => array('/community'),
									'itemOptions' => array(
										'class' => 'green',
									),
								),
								/*array(
									'label' => '<span>Конкурсы</span>',
									'url' => Yii::app()->createUrl('/contest/contest/view', array('id'=>1)),
									'itemOptions' => array(
										'class' => 'yellow',
									),
								),
								array(
									'label' => '<span>Календарь малыша</span>',
									'url' => array('/calendar'),
									'itemOptions' => array(
										'class' => 'orange',
									),
								),*/
							),
						));
					?>
				</div>
				
			</div>
			
		</div>
		
		<?php
			/*$this->widget('zii.widgets.CBreadcrumbs', array(
				'separator' => ' &nbsp;>&nbsp; ',
				'encodeLabel' => false,
				'htmlOptions' => array(
					'class' => null,
					'id' => 'crumbs',
				),
				'links' => $this->breadcrumbs,
			));*/
		?>
		<br /> <br />
		
		<div id="content">

			<?php echo $content; ?>

		</div>
		<div class="clear"></div>
		<div class="empty"></div>
	
		<div class="footer">
			<div class="violett">
				<?php echo CHtml::link('Веселый Жираф', '/'); ?>
				<?php echo CHtml::link('Клубы', Yii::app()->controller->createUrl('/community')); ?>
				<?php echo CHtml::link('Карта', Yii::app()->controller->createUrl('site/map')); ?>
			</div>
		</div>
	

	</div>
	<?php $this->widget('LoginWidget'); ?>
	
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