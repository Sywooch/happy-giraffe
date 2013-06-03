<?php
class SuccessAction extends PSAction
{
    public function run()
    {
		$payment = $this->handledPayment = BillingPayment::model()->findByPk(intval($_POST['LMI_PAYMENT_NO']), 'payment_accept_time>0');

		$payment->invoke('success', $_POST, time());

//		array(
//			'transfer_id'		=>'LMI_PAYMENT_NO',
//			'ps_transfer_no'	=>'LMI_SYS_TRANS_NO',
//			'ps_transfer_date'	=>'LMI_SYS_TRANS_DATE',
//			'ps_invoice_no'		=>'LMI_SYS_INVS_NO',
//			'ps_amount'			=>'LMI_PAYMENT_AMOUNT',
//			'payer_purse'		=>'LMI_PAYER_PURSE',
//			'payer_account'		=>'LMI_PAYER_WM',
//		);

    }

}?>
