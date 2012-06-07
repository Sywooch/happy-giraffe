<table>
	<?php
	$this->widget('zii.widgets.CListView', array(
		'dataProvider' => $dataProvider,
		'itemView' => '_listTable',
		'template' => "{items}",
		'tagName' => 'div',
		'emptyText' => '',
		'viewData' => array('OrderId' => $OrderId),
		'itemsTagName' => 'div',
		'itemsCssClass' => 'foto_nev',
	));
	?>
</table>