<?php
$this->breadcrumbs=array(
	'Points Histories'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List PointsHistory', 'url'=>array('index')),
	array('label'=>'Manage PointsHistory', 'url'=>array('admin')),
);
?>

<h1> Create PointsHistory </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'points-history-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
