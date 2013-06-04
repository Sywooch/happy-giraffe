<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.cheque {border: 1px solid #000;}
.cheque table {margin: 0px; padding: 0px;}
.cheque .kassir {width: 150px;  text-align: center; /*vertical-align: bottom*/}
.cheque .requisites { text-align: center;}
.cheque .line { border-bottom: 1px solid #000; height: 25px; text-align: center;}
.cheque .line-under { font-size:10px; text-align: center;}
.cheque .hrb {border-bottom: 1px solid #000;}
.cheque .hrr {border-right: 1px solid #000;}
.cheque .ctr {text-align: center}
.cheque .pad {padding: 5px}
.cheque tr, .cheque td {padding: 0px; margin: 0px;}
</style>
<table class="cheque" align="center">
	<tr>
		<td class="kassir hrb hrr" ><div><i>Извещение</i></div></td>
		<td class="requisites hrb" align="center"><? ob_start();?>
		<div class="pad">
		<?php echo CHtml::encode($requisite->requisite_name); ?><br>
		Расчётный счёт <b><?php echo CHtml::encode($requisite->requisite_account); ?></b>,
		банк <?php echo CHtml::encode($requisite->requisite_bank); ?>
		<?if ($requisite->requisite_bank_address) echo ', '.CHtml::encode($requisite->requisite_bank_address); ?>
		<br/>
		<? $info=array();
		foreach(array('БИК'=>'requisite_bik','Корр. счет'=>'requisite_cor_account','ИНН'=>'requisite_inn','КПП'=>'requisite_kpp') as $t=>$n) {
			if (strlen($requisite->$n)) $info[] = CHtml::encode("$t: {$requisite->$n}");
		}
		if($info) echo implode(", ",$info)."<br/>";
		?>
		<br/>
		</div>
		<div class="line">&nbsp;<?=CHtml::encode($payment->invoice->invoice_payer_name)?></div>
		<div class="line-under">(Ф.И.О. плательщика полностью)</div>
		<div class="line">&nbsp;</div>
		<div class="line-under">(адрес плательщика)</div>
		<div class="line">&nbsp;</div>
		<?php $sum=explode('.',number_format($payment->payment_amount,2,'.',' ')); ?>
		<table width="100%">
			<tr>
				<td class="pad hrb hrr">Дополнительная информация:</td>
				<td class="pad hrb">Сумма</td>
			</tr>
			<tr>
				<td class="pad hrb hrr"><?=CHtml::encode($payment->payment_description)?></td>
				<td class="pad hrb"><?=$sum[0]?> руб <?=$sum[1]?> коп</td>
			</tr>
		</table>
		<div class="ctr" style="height: 30px"><?=Num2str::doit($payment->payment_amount)?></div>
		<div class="ctr pad">Подпись плательщика ________________ «___»_______20___г.</div><br/>
		<?	$body = ob_get_clean(); ?>
		<?=$body?>
	</tr>
	<tr>
		<td class="kassir hrr" ><i>Квитанция</i></td>
		<td class="requisites" align="center"><?=$body?></td>
	</tr>
</table>

<?php /*
<div class="view">
	<div style="float: right">
	<?=CHtml::beginForm();?>
	<?=CHtml::hiddenField('requisite_id', $data->requisite_id);?>
	<?=CHtml::submitButton(' выбрать ')?>
	<?=CHtml::endForm();?>
	</div>

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_name')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bank')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bank); ?>
	<br />

	<?php if($data->requisite_bank_address): ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bank_address')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bank_address); ?>
	<br />
	<?php endif; ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_account')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_bik')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_bik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_inn')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_inn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite_kpp')); ?>:</b>
	<?php echo CHtml::encode($data->requisite_kpp); ?>
	<br />
</div>
 *
 */
?>