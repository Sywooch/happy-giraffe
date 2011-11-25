<?php
$this->pageTitle=Yii::app()->name . ' - Профиль';
$this->breadcrumbs=array(
	'Профиль',
);
?>

<h1>Профиль</h1>'

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
		'Главное' => CController::renderPartial('profile/general', array('model' => $model, 'regions' => $regions), TRUE),
		'Дети' => CController::renderPartial('profile/babies', array('babies' => $babies), TRUE),
		'Социалки' => CController::renderPartial('profile/social_services', array('services' => $model->social_services), TRUE),
	),
	
	
));
?>
