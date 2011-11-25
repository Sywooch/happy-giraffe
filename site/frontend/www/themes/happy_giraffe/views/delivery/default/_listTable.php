<tr>
	<td class="col-1">
		<?php
		$url = array(
			"name" => $data["id"],
			"city" => $data["destination"]
		);
		
		if($OrderId)
			$url = array_merge($url, array("OrderId" => $OrderId));
		
		$url = $this->createUrl("/delivery/default/selectDeliveryModule",$url);
		
//		echo CHtml::link(
//			'sel', $url, array("class" => $data['htmlclass'])
//		);
		?>
		<label>
			<input type="radio" name="radio" rel="<?php echo $url;?>" class="<?php echo $data['htmlclass'];?>"/>
			<?php echo $data['name']; ?>
		</label> <a class="info"></a>
	</td>
	<td class="col-2"><b><?php echo $data['price']; ?></b> руб.</td>
	<td class="col-3"><?php echo $data['destination']; ?></td>
</tr>