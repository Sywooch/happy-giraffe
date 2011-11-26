<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Untitled Document</title>
	
	
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!--   	--><?php //Yii::app()->clientScript->registerCssFile('/stylesheets/wym.css'); ?>
   	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/global.css'); ?>
   	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/common.css'); ?>
   	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css'); ?>

   	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/cusel.css'); ?>

   	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
   	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/cusel.js'); ?>
   	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/checkbox.js'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css'); ?>
   	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js'); ?>

   	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/common.js'); ?>

   	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/ie.css', 'screen'); ?>

   	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.iframe-post-form.js'); ?>

	<!--[if IE 7]>
		<link rel="stylesheet" href='/stylesheets/ie.css' type="text/css" media="screen" />
	<![endif]-->
	
</head>
<body class="body-club">
	<div id="layout" class="wrapper">
		
		<div id="header" class="clearfix">
			
			<div class="logo-box">
				<a href="" class="logo"></a>
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
                        <a href="#login" class="fancy">Вход</a>
                        |
                        <?php echo CHtml::link('Регистрация', '/club/signup'); ?>
                    <?php else: ?>
                        <span class="welcome"><b>Добро пожаловать,</b> <?php echo CHtml::link(Yii::app()->user->first_name, Yii::app()->createUrl('../shop/profile/index')); ?></span>
                        <?php echo CHtml::link('Выход', Yii::app()->createUrl('../club/site/logout')); ?>
                    <?php endif; ?>
                </div>
				
			</div>
			
		</div>

        <div id="nav" class="clearfix">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'encodeLabel' => false,
                    'items' => array(
                        array(
                            'label' => '<span>Форумы</span>',
                            'url' => array('/community/list', 'community_id' => 5),
                            'itemOptions' => array(
                                'style' => 'background-color:#ac89ce;',
                            ),
                        ),
                        array(
                            'label' => '<span>Календарь малыша</span>',
                            'url' => array('/calendar'),
                            'itemOptions' => array(
                                'style' => 'background-color:#f89731;',
                            ),
                        ),
                        array(
                            'label' => '<span>Бюджет малыша</span>',
                            'url' => array('/calendar'),
                            'itemOptions' => array(
                                'style' => 'background-color:#67bd51;',
                            ),
                        ),
                        array(
                            'label' => '<span>День рождения</span>',
                            'url' => array('/calendar'),
                            'itemOptions' => array(
                                'style' => 'background-color:#41b3cc;',
                            ),
                        ),
                        array(
                            'label' => '<span>Конкурсы</span>',
                            'url' => array('/contest/1'),
                            'itemOptions' => array(
                                'style' => 'background-color:#fad84a;',
                            ),
                        ),
                    ),
                ));
            ?>
        </div>

		<div id="crumbs">
			<a href="">Главная</a>
			&nbsp;>&nbsp;
			<a href="">Клуб</a>
			&nbsp;>&nbsp;
			<b>Календарь прививок ребенка</b>
		</div>
		
		<div id="content">
			
			<div id="baby">
				<div class="content-box clearfix">
					<div class="main main-right">
						<div class="main-in">
                            <?php echo $content; ?>
						</div>
					</div>
					
					<div class="side-left">

						<div class="banner-box">
							<a href="#"><img src="/images/leftban.png"></a>
						</div>
						
					</div>
					
				</div>
			</div>
		
			
		</div>  	
		<div class="push"></div>
	</div>
	<div id="footer" class="wrapper">
		f
	</div>
    <?php $this->widget('LoginWidget'); ?>
</body>
</html>
