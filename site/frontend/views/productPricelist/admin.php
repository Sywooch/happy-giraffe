<?php
$this->breadcrumbs=array(
	'Product Pricelists'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create ProductPricelist', 'url'=>array('create')),
	array('label'=>'Create ProductPricelist By Exist', 'url'=>array('createBy')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-pricelist-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Pricelists</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-pricelist-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'pricelist_id',
		'pricelist_title',
//		'price_list_settings',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{createBy} {update} {settings} {delete}',
			'buttons'=>array(
				'createBy'=>array(
					'label'=>'Create By Exist',
					'url'=>'array("createBy","id"=>$data->pricelist_id)',
					'imageUrl'=>'/shop/images/external.png',
				),
				'settings'=>array(
					'label'=>'Settings',
					'url'=>'array("settings","id"=>$data->pricelist_id)',
					'imageUrl'=>'/shop/images/settings.png',
				),
			),
		),
	),
)); ?>
