<?php
$this->breadcrumbs=array(
	'Банковский платёж',
);

?>

<h1>Банковский платёж</h1>
<?php $this->renderPartial('BANK/_print', array(
	'requisite'=>$requisite,
	'payment'=>$payment,
)); ?>

<p><?=Chtml::link('Распечатать',
		array('','do'=>'print','requisite_id'=>$requisite->requisite_id, 'payment_id'=>$payment->payment_id),
		array('target'=>'_blank')
)?></p>
<p><?=Chtml::link('Дальше',$this->module->getNextUrl())?></p>