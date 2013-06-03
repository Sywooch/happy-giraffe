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

		$payment->invoke('accept', null, time());

		$this->controller->redirect($this->controller->module->getNextUrl());
    }

}?>