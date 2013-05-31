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
	
		$model = new BillingSystemPaymentFormQIWI('create');
		$model->unsetAttributes();

		if (isset($_POST['BillingSystemPaymentFormQIWI'])) {
			$model->attributes = $_POST['BillingSystemPaymentFormQIWI'];

			if($model->validate()) {
				$model->form_time = time();
				$model->form_payment_id = $payment->payment_id;
				$model->save(false);
				require_once(($dir=dirname(__FILE__)).'/qiwi.inc.php');
				$cfg = array_merge(
					require_once($dir . '/qiwi.cfg.php'),
					$system->getParameters()
				);
				$qiwi = QIWI::getInstance($cfg);
				try {
					$info = null;
					$ok = $qiwi->createBill($bill=array(
						'phone' => substr($model->form_gsm,-10),
						'amount' => round($payment->payment_amount,2),
						'comment' => $payment->payment_description,
						'txn-id' => $payment->payment_id
						)
					);
				} catch (QIWIMortalCombatException $e) {
				//	file_put_contents(dirname(__FILE__).'/check/.'.$txnId, http_build_query($bill)."\n".'Failed: ' . $e->code . ', ' . ($e->fatality?"true":"false") . ', ' . QIWI::$errors[$e->code]);
					$info = 'Failed: ' . $e->code . ', ' . ($e->fatality?"true":"false") . ', ' . QIWI::$errors[$e->code];
					$ok=false;
				}
				//exit(print_r($info));
				$payment->invoke('accept', $info, time(),$ok ?null :-1);
				$this->controller->redirect(
					array($system->system_code, 'do'=>'complete','fid'=>$model->form_id)
				);
			}
		}

		$this->render('create',array(
			'system'=>$system,
			'payment'=>$payment,
			'model'=>$model
		));
    }
	/*
	 *
	 */
    public function doComplete()
    {
		$system		= $this->getSystem();

		$form_id = isset($_GET['fid']) ?intval($_GET['fid']) :null;
		$form = BillingSystemPaymentFormQIWI::model()->findByPk($form_id);
		if (!$form) $this->Fail404();
		
		$payment = $this->handledPayment = BillingPayment::model()->findByPk(
			$form->form_payment_id
		);
		if (!$payment) $this->Fail404();

		$this->render('complete',array(
			'system'=>$system,
			'payment'=>$payment
		));
    }

}?>