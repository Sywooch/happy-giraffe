<?php
$this->breadcrumbs=array(
	'Name Famouses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List NameFamous', 'url'=>array('index')),
	array('label'=>'Create NameFamous', 'url'=>array('create')),
	array('label'=>'View NameFamous', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NameFamous', 'url'=>array('admin')),
);
?>

<h1> Update NameFamous #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'name-famous-form',
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
