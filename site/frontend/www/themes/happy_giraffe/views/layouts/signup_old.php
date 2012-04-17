<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/common.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/registration.css'); ?>
	
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	
	<?php Yii::app()->clientScript->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js'); ?>
	
	<?php Yii::app()->clientScript->registerScriptFile('/javascripts/common.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.placeholder.min.js'); ?>
	
	<!--[if IE 7]>
		<?php Yii::app()->clientScript->registerCssFile('/stylesheets/ie.css'); ?>
	<![endif]-->
	
</head>
<body>

<?php echo $content; ?>
</body>
</html>