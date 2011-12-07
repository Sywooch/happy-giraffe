<?php
class PayAction extends PSAction
{
    public function doCreate()
    {
		$system		= $this->getSystem();
		$payment_id = isset($_GET['payment_id']) ?intval($_GET['payment_id']) :null;
		$payment	= $this->handledPayment = BillingPayment::model()->findByPk(
			$payment_id, 'payment_status=0 AND payment_system_id='.$system->system_id
		);
		if (!$payment) $this->Fail404();

		$params = $system->getParameters();
		$requisite = BillingSystemBANKRequisite::model()->findByPk(1);
		if($requisite) {
			$payment->invoke('accept', array('requisite_id'=>$requisite->requisite_id), time());
			$this->controller->redirect($this->controller->module->getNextUrl());
			$this->render('view',array(
				'system'=>$system,
				'payment'=>$payment,
				'requisite'=>$requisite
			));
			return;
		}

		$dataProvider=new CActiveDataProvider('BillingSystemBANKRequisite');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'system'=>$system,
			'payment'=>$payment
		));
    }
    public function doPrint()
    {
		if (empty($_GET['requisite_id']) || empty($_GET['payment_id'])) {
			$this->Fail404();
		}

		$system		= $this->getSystem();
		$payment_id = intval($_GET['payment_id']);
		$payment	= $this->handledPayment = BillingPayment::model()->findByPk($payment_id);
		$requisite = BillingSystemBANKRequisite::model()->findByPk($_GET['requisite_id']);
		if (!$payment || !$requisite) {
			$this->Fail404();
		}
		$this->controller->layout = $this->controller->module->printLayout;
		$this->render('_print',array(
			'system' => $system,
			'payment' => $payment,
			'requisite' => $requisite
		));
    }

}?>