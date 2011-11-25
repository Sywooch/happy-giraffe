<?php
$this->breadcrumbs = array(
	'Community Contents',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' CommunityContent', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' CommunityContent', 'url'=>array('admin')),
);
?>

<h1>Community Contents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
