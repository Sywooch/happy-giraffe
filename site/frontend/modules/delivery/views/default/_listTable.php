<tr class="odd">
    <td><?php echo $data['id'];?></td>
    <td><?php echo $data['name'];?></td>
    <td><?php echo $data['destination'];?></td>
    <td><?php echo $data['price'];?></td>
    <td style="width:100px;">
	<?php echo CHtml::link(
		'sel', 
		array(
		    "/delivery/default/selectDeliveryModule", 
		    "OrderId"=>$OrderId, 
		    "name"=>$data["id"], 
		    "city"=>$data["destination"]
		), 
		array("class"=>$data['htmlclass'])
		);
	?>
    </td>
</tr>
