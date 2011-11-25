<?php
$this->breadcrumbs=array(
	'Product Attribute Sets'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage ProductAttributeSet', 'url'=>array('admin')),
);
?>

<h1>Create ProductAttributeSet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>