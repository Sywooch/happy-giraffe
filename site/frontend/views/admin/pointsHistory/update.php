<?php
$this->breadcrumbs=array(
	'Points Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List PointsHistory', 'url'=>array('index')),
	array('label'=>'Create PointsHistory', 'url'=>array('create')),
	array('label'=>'View PointsHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PointsHistory', 'url'=>array('admin')),
);
?>

<h1> Update PointsHistory #<?php echo $model->id; ?> </h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Update')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
