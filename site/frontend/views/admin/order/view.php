<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->order_id,
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Update Order', 'url'=>array('update', 'id'=>$model->order_id)),
	array('label'=>'Delete Order', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->order_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<h1>View Order #<?php echo $model->order_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'order_id',
		array(
			'name'=>'order_status',
			'value'=>$model->getStatusText(),
		),
		'order_payed:boolean',
		'order_time:datetime',
		'order_user_id',
		'order_item_count',
//		'order_price',
		'order_price_total',
//		'order_width',
//		'order_volume',
		'order_description',
		'order_price_delivery',
		'order_delivery_adress',
//		'order_vaucher_id',
	),
)); ?>

<h3>Products</h3>

<table>
<?php foreach ($items as $position): ?>
	<tr>
		<td>
			<?php echo CHtml::image(UFiles::getFileInstance($position['product_image'])->getUrl("thumb"), $position['product_title']); ?>
		</td>
		<td>
			<?php echo $position['product_title']; ?>
		</td>
		<td>
			<?php
			$item_product_property = CJSON::decode($position['item_product_property']);
			foreach ($item_product_property as $property)
			{
				echo "{$property['attribute_title']} - {$property['eav_attribute_value']}<br/>";
			}
			?>
		</td>
		<td>
			<?php echo $position['item_product_cost']; ?> руб
		</td>
		<td>
			<?php echo $position['item_product_count']; ?>
		</td>
		<td>
			<?php echo $position['item_product_cost'] * $position['item_product_count']; ?> руб
		</td>
	</tr>
<?php endforeach; ?>
</table>