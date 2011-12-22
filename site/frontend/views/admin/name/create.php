<?php
$this->breadcrumbs=array(
	'Names'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List Name', 'url'=>array('index')),
	array('label'=>'Manage Name', 'url'=>array('admin')),
);
?>

<h1> Create Name </h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
