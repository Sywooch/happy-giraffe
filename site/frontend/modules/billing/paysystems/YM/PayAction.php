<?php
class PayAction extends PSAction
{
    public function doCreate()
    {
		$system		= $this->getSystem();
		$payment_id = isset($_GET['payment_id']) ?intval($_GET['payment_id']) :null;
		$payment	= $this->handledPayment = BillingPayment::model()->findByPk(
			$payment_id, 'payment_accept_time=0 AND payment_system_id='.$system->system_id
		);
		if (!$payment) $this->Fail404();

		$payment->payment_accept_time = time();
		$payment->update(array('payment_accept_time'));

		$params = $system->getParameters();
		?>
		<html>
		<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
		<body>
		<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
		<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?=round($payment->payment_amount,2)?>">
		<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="<?=base64_encode($payment->payment_description)?>">
		<input type="hidden" name="LMI_PAYMENT_NO" value="<?=$payment->payment_id?>">
		<input type="hidden" name="LMI_PAYEE_PURSE" value="<?=$params['purse']?>">
		<input type="hidden" name="LMI_SIM_MODE" value="0">
		<input type="hidden" name="LMI_RESULT_URL" value="<?=$this->getController()->createAbsoluteUrl('return/result/'.$this->psCode)?>">
		<input type="hidden" name="LMI_RESULT_METHOD" value="POST">
		<input type="hidden" name="LMI_SUCCESS_URL" value="<?=$this->getController()->createAbsoluteUrl('return/success/'.$this->psCode)?>">
		<input type="hidden" name="LMI_SUCCESS_METHOD" value="POST">
		<input type="hidden" name="LMI_FAIL_URL" value="<?=$this->getController()->createAbsoluteUrl('return/fail/'.$this->psCode) ?>">
		<input type="hidden" name="LMI_FAIL_METHOD" value="POST">
		</form>
		<!--script>document.forms[0].submit();</script-->
		</body></html>
		<?
    }
}?>
