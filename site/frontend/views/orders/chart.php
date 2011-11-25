<chart>
	<chart_data>
		<row>
			<null/>
			<?php foreach ($orders as $order): ?>
			<string><?php echo $order['day'] ?></string>
			<?php endforeach ?>
		</row>
		<row>
			<string>Orders</string>
			<?php foreach ($orders as $order): ?>
			<number><?php echo $order['payments'] ?></number>
			<?php endforeach ?>
		</row>
	</chart_data>
</chart>
