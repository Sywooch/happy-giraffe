<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->pageTitle; ?></title>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/common.css'); ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
</head>
<body>
    <?php echo $content; ?>
</body>
</html>