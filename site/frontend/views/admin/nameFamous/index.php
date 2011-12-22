<?php
$this->breadcrumbs = array(
	'Name Famouses',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' NameFamous', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' NameFamous', 'url'=>array('admin')),
);
?>

<h1>Name Famouses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
