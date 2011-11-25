<?php
$this->breadcrumbs=array(
	'Банковский платёж',
);

?>

<h1>Банковский платёж</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'BANK/_view',
)); ?>
