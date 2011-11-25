<h1>Shoppping Card</h1>

<table>
<?php foreach (Yii::app()->shoppingCart->getPositions() as $position): ?>
	<tr>
		<td>
			<?php echo CHtml::image($position->product_image->getUrl("thumb"), $position->product_title); ?>
		</td>
		<td>
			<?php echo $position->product_title; ?>
		</td>
		<td>
			<?php echo $position->getPrice(); ?> руб
		</td>
		<td>
			<?php echo CHtml::link('sub', array('shop/putIn', 'id'=>$position->product_id, 'count'=>-1)); ?>
			<?php echo $position->getQuantity(); ?>
			<?php echo CHtml::link('add', array('shop/putIn', 'id'=>$position->product_id, 'count'=>1)); ?>
		</td>
		<td>
			<?php echo $position->getSumPrice(); ?> руб
		</td>
	</tr>
<?php endforeach; ?>
	<tr>
		<td colspan="4">Total</td>
		<td>
			<?php echo Yii::app()->shoppingCart->getCost(false); ?> руб
		</td>
	</tr>
	<tr>
		<td colspan="4">Discount</td>
		<td>
			<?php echo Yii::app()->shoppingCart->getDiscount(); ?> руб
		</td>
	</tr>
	<tr>
		<td colspan="4">Cost</td>
		<td>
			<?php echo Yii::app()->shoppingCart->getCost(true); ?> руб
		</td>
	</tr>
</table>

<?php echo CHtml::link('Checkout', array('/order/create'), array('id'=>'checkout')); ?>

<?php $this->widget('ext.fancybox.EFancyBox', array(
	'target' => '#checkout',
)); ?>