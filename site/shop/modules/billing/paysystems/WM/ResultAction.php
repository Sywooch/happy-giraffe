<?php
class ResultAction extends PSAction
{

    public function run()
    {
	//	mail('vvdevel@gmail.com','WMTEST',print_r($_POST,true)."\nGET".print_r($_GET,true)."\nSERVER".print_r($_SERVER,true));    
		if (!empty($_POST['LMI_PREREQUEST'])) {
			exit("YES");
		}

		$POST   = $_POST;
		$system	= $this->getSystem();
		$params = $system->getParameters();

        $control= $POST['LMI_PAYEE_PURSE'] . $POST['LMI_PAYMENT_AMOUNT'] . $POST['LMI_PAYMENT_NO']
                . $POST['LMI_MODE'] . $POST['LMI_SYS_INVS_NO'] . $POST['LMI_SYS_TRANS_NO']
                . $POST['LMI_SYS_TRANS_DATE'] . $params['secret_key'] . $POST['LMI_PAYER_PURSE']
                . $POST['LMI_PAYER_WM'];
        if (strtoupper(md5($control)) != strtoupper($POST['LMI_HASH'])) {
			$this->Fail('FAIL:SYNC');
        }

		$payment = $this->handledPayment = BillingPayment::model()->findByPk($POST['LMI_PAYMENT_NO'], 'payment_result_time=0');

		if (!$payment) $this->Fail('FAIL:UNDEF_PAYMENT:'.$POST['LMI_PAYMENT_NO']);

		$payment->invoke('result', $_POST, time(), 1);
    }

}?>
