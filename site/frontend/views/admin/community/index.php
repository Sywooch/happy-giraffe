<?php
$this->breadcrumbs = array(
	'Communities',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Community', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Community', 'url'=>array('admin')),
);
?>

<h1>Communities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
