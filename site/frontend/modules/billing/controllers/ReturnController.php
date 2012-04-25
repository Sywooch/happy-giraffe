<?php

class ReturnController extends HController
{
	public function actionResult()
	{
		if (!$this->runPaySystemAction('Result')) {
			$this->Fail404();
		}
	}
	public function actionSuccess()
	{
		$payment = $this->runPaySystemAction('Success');
		$this->render('success',array('payment'=>$payment));
	}
	public function actionFail()
	{
		$payment = $this->runPaySystemAction('Fail');
		$this->render('fail',array('payment'=>$payment));
	}

	function runPaySystemAction($mode)
	{
		$systems = array_flip(BillingSystem::enum('system_id,system_code'));
		foreach($_GET as $ps=>$v) {
			if ($systems[$ps]) {
				$action=Yii::createComponent(array('class'=>"billing.paysystems.{$ps}.{$mode}Action",'psCode'=>$ps),$this,$mode);
				$this->runAction($action);
				return $action->handledPayment;
			}
		}
		return null;
	}

}