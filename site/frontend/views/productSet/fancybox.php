<?php echo CHtml::link('All Products', array('products','id'=>$model->set_id), array(
	'class'=>'products',
)); ?>

<?php echo CHtml::link('Add Products', array('add','id'=>$model->set_id), array(
	'class'=>'productAdd',
)); ?>

<?php $this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'.products, .productAdd',
));?>