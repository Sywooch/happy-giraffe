<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#">
<head>
	<?php echo CHtml::metaTag('text/html; charset=utf-8', NULL, 'Content-Type'); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php //Yii::app()->clientScript->registerCssFile('/stylesheets/wym.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/global.css?r=112'); ?>

	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css?r=112'); ?>
	



	

	



	





	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27545132-1']);
	  _gaq.push(['_trackPageview']);
      var ga;

	  (function() {
	    ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>


    <script type="text/javascript">
        var base_url = '<?php echo Yii::app()->baseUrl; ?>';
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
                    <form action="<?php echo $this->createUrl('site/search'); ?>">
                        <button class="btn"><span><span>Поиск</span></span></button>
                        <div class="text">
                            <input type="text" name="text" />
                        </div>
                    </form>
				</div>
				<?php $this->widget('site.frontend.widgets.loginWidget.LoginWidget'); ?>
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
		
		<div id="content" class="clearfix">

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

    <script id="notificationTmpl" type="text/x-jquery-tmpl">
        <li><?php echo CHtml::link('${text}', '${url}', array(
            'id' => '{$_id}',
        )) ;?></li>
    </script>

    Отработало за <?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?> с. Скушано памяти: <?=round(memory_get_peak_usage()/(1024*1024),2)."MB"?>
</body>
</html>