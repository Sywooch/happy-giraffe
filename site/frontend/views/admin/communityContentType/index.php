<?php
$this->breadcrumbs = array(
	'Community Content Types',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' CommunityContentType', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' CommunityContentType', 'url'=>array('admin')),
);
?>

<h1>Community Content Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
