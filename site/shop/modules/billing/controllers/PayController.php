<?php

class PayController extends HController
{
	function actions()
	{
		$actions = array();
		foreach(BillingSystem::enum('system_id,system_code') as $code) {
			$actions[$code] = array('class'=>"billing.paysystems.{$code}.PayAction",'psCode'=>$code);
		}
		return $actions;
	}
	
	/**
	 * Creates a new payment.
	 */
	public function actionCreate($invoice_id)
	{
		$model=new BillingPayment('create');
		$model->unsetAttributes();
		$model->payment_invoice_id = $invoice_id;
		if (!($invoice=BillingInvoice::model()->findByPk($invoice_id))) {
			throw new CHttpException(404,Yii::t('controllers','Page not found.'));
		}

		if (isset($_POST['BillingPayment']))
		{
			$model->attributes = $_POST['BillingPayment'];
			$model->payment_currency = $invoice->invoice_currency;
			$model->payment_description = $invoice->invoice_description;
			if($model->save()) {
				$systems = BillingSystem::enum('system_id,system_code');
				$this->redirect(
					array('pay/'.$systems[$model->payment_system_id], 'payment_id'=>$model->payment_id)
				);
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'invoice'=>$invoice
		));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}