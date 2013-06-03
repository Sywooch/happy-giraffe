<?php
$this->breadcrumbs=array(
	'QIWI',
);

?>

<h1>QIWI платёж</h1>
<? if($payment->payment_status!=-1):?>
<p>Вам выставлен счет на QIWI кошелек. Оплатите его любым удобным для Вас способом.</p>
<? else: ?>
<p>Ошибка выставления счета на QIWI кошелек. Попробуйте позже.</p>
<? endif;?>
<p><?=Chtml::link('Дальше',$this->module->getNextUrl())?></p>