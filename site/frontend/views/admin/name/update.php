<?php
$this->breadcrumbs=array(
	'Names'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List Name', 'url'=>array('index')),
	array('label'=>'Create Name', 'url'=>array('create')),
	array('label'=>'View Name', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Name', 'url'=>array('admin')),
);
?>

<h1> Update Name #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'name-form',
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
