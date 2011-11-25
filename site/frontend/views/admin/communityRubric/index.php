<?php
$this->breadcrumbs = array(
	'Community Rubrics',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' CommunityRubric', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' CommunityRubric', 'url'=>array('admin')),
);
?>

<h1>Community Rubrics</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
