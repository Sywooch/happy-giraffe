<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php Yii::app()->clientScript->registerCssFile('/stylesheets/common.css?r=112'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css?r=112'); ?>
    <?php Yii::app()->clientScript->registerCssFile('/stylesheets/store.css?r=112'); ?>

    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/checkbox.js?r=111'); ?>

    <?php Yii::app()->clientScript->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css?r=112'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js?r=111'); ?>

    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/common.js?r=111'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.mousewheel.js?r=111'); ?>


    <!--[if IE 7]>
    <?php Yii::app()->clientScript->registerCssFile('/stylesheets/ie.css?r=112'); ?>
    <![endif]-->
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
		";
    Yii::app()->clientScript->registerScript('reports_', $reports);
    ?>
</head>
<body class="body-club">
<div id="layout" class="wrapper">

    <div id="header" class="clearfix">

        <div class="logo-box">
            <a href="/" class="logo"></a>
        </div>

        <div class="header-in">

            <div class="search-box">
                <button class="btn"><span><span>Поиск</span></span></button>
                <div class="text">
                    <input type="text"/>
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
                <ul>
                    <li class="green"><a href=""><span>Форумы</span></a></li>
                    <li class="yellow"><a href=""><span>Конкурсы</span></a></li>
                    <li class="orange"><a href=""><span>Календарь малыша</span></a></li>
                </ul>
            </div>

        </div>

    </div>

    <div id="crumbs">
        <a href="">Главная</a>
        &nbsp;>&nbsp;
        <b>Мои сообщения</b>
    </div>

    <div id="content" class="clearfix">
        <?php echo $content ?>
    </div>
    <div class="push"></div>
</div>
<div id="footer" class="wrapper">
    f
</div>
</body>
</html>