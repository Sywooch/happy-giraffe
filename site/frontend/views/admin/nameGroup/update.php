<?php
$this->breadcrumbs=array(
	'Name Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List NameGroup', 'url'=>array('index')),
	array('label'=>'Create NameGroup', 'url'=>array('create')),
	array('label'=>'View NameGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NameGroup', 'url'=>array('admin')),
);
?>

<h1> Update NameGroup #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'name-group-form',
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
