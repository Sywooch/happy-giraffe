<?php
$this->breadcrumbs=array(
	'Vaccines'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List Vaccine', 'url'=>array('index')),
	array('label'=>'Create Vaccine', 'url'=>array('create')),
	array('label'=>'View Vaccine', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Vaccine', 'url'=>array('admin')),
);
?>

<h1> Update Vaccine #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vaccine-form',
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
