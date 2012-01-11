<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<!-- blueprint CSS framework -->
	<?php $this->widget('ext.blueprint.EBlueprintWidget',array(
		'plugins'=>array('sprites'))
	);?>

	<link rel="stylesheet" type="text/css" href="/club/css/main.css" />
	<link rel="stylesheet" type="text/css" href="/club/css/form.css" />
	<link rel="stylesheet" type="text/css" href="/club/style.css" />

	<?php
	Yii::app()->clientScript->registerCssFile('http://www.odnoklassniki.ru/oauth/resources.do?type=css');
	Yii::app()->clientScript->registerScriptFile('http://www.odnoklassniki.ru/oauth/resources.do?type=js',  CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile('http://cdn.connect.mail.ru/js/loader.js',  CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile('http://vkontakte.ru/js/api/openapi.js',  CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('vkInit',
			"VK.init({apiId: 2450198});",
			CClientScript::POS_HEAD
		);
	?>

	<script src="/club/js/ready.js"  type="text/javascript"></script>

	<!-- Charts -->
	<script language="javascript">AC_FL_RunContent = 0;</script>
	<script language="javascript"> DetectFlashVer = 0; </script>
	<script src="/club/charts/AC_RunActiveContent.js" language="javascript"></script>
	<script language="JavaScript" type="text/javascript">
		<!--
		var requiredMajorVersion = 10;
		var requiredMinorVersion = 0;
		var requiredRevision = 45;
		-->
	</script>
	<!-- /Charts -->

</head>

<body>
<div class="overlay"></div>

<div id="wait_popup" class="pop-up">
	<img alt="Подождите, пожалуйста..."  src="/club/images/wait.gif" />
</div>

<?php if (false): ?>

<div id="login_popup" class="pop-up" style="background-color: white; height: 300px; width: 400px; padding: 5px;">
	<h2>Войти</h2>
	<div class="form">
		<?php $userModel = new User; ?>
		<?php echo CHtml::errorSummary($userModel); ?><br />
		<?php $form=$this->beginWidget('CActiveForm', array(
			'action' => $this->createUrl('site/login'),
			'id'=>'user-form',
			'enableAjaxValidation'=>true,
			'clientOptions'=>array('validateOnSubmit'=>true, 'validateOnChange' => false),
		)); ?>
		<div class="row">
			<?php echo $form->labelEx($userModel,'email'); ?>
			<?php echo $form->textField($userModel,'email',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($userModel,'email'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($userModel,'password'); ?>
			<?php echo $form->passwordField($userModel,'password',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($userModel,'password'); ?>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton('Войти'); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div>
	<?php Yii::app()->eauth->renderWidget(array('action' => 'site/login')); ?>
	<br />
	<br />
	<a class="popup_close" href="">Закрыть</a>
</div>

<?php endif; ?>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php
//		$this->widget('zii.widgets.CMenu',array(
		$this->widget('ext.mbmenu.MbMenu',array(
			'items'=>require_once(dirname(__FILE__).'/shop_menu.php'),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php $this->widget('ext.userFlash.EUserFlash');?>

	<?php echo $content; ?>

	<div id="footer">
		<?php $this->widget('ext.PerformanceStatisticWidget');?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>