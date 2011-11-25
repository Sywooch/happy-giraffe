<h1>Shoppping Card</h1>

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
	<tr>
		<td colspan="4">Total</td>
		<td>
			<?php echo $order['order_price']; ?> руб
		</td>
	</tr>
	<tr>
		<td colspan="4">Discount</td>
		<td>
			<?php echo $order['order_price']-$order['order_price_total']; ?> руб
		</td>
	</tr>
	<tr>
		<td colspan="4">Delivery</td>
		<td>
			<?php echo $delivery['cost']; ?> руб
		</td>
	</tr>
	<tr>
		<td colspan="4">Cost</td>
		<td>
			<?php echo $order['order_price_total'] + $delivery['cost']; ?> руб
		</td>
	</tr>
</table>

<?php echo CHtml::link('Pay', array(
	'/billing/invoice/create/',
//	'id'=>$order_id,
	'invoice_order_id'=>$order['order_id'],
	'invoice_amount'=>$order['order_price_total'] + $delivery['cost'],
	'invoice_currency'=>'RUR',
	'invoice_description'=>$order['order_description']
		? $order['order_description']
		: "Order #{$order['order_id']}",
	'invoice_payer_id'=>Y::userId(),
//	'invoice_payer_name'
//	'invoice_payer_email'
//	'invoice_payer_gsm'
)); ?>