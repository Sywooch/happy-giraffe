<?php

class BillingModule extends CWebModule
{
	public $layout='//layouts/column2';
	public $printLayout=false;

	public $urlNext=null;
	public $urlNextUserState="billing_url_next";
	public $callbackOrderProceed = null;
	public $callbackOrderPaid = null;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'billing.models.*',
			'billing.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public function getNextUrl()
	{
		if ($this->urlNextUserState) {
			$url = Yii::app()->user->getState($this->urlNextUserState);
		}
		return empty($url) ?($this->urlNext ?$this->urlNext :'/') :$url;
	}

	public function paymentSystems()
	{
		return BillingSystem::model()->select('*','system_status=1');
	}
	
	public function getPsByOrder($id, $field = 'system_code')
	{
		return Y::command()
			->select($field)
			->from(BillingSystem::model()->tableName())
			->leftJoin(BillingPayment::model()->tableName(), 'payment_system_id=system_id')
			->leftJoin(BillingInvoice::model()->tableName(), 'payment_invoice_id=invoice_id')
			->where('invoice_order_id=:invoice_order_id', array(
				':invoice_order_id'=>(int)$id,
			))
			->order('payment_status DESC, payment_id DESC')
			->queryScalar();
	}
	
	public function getPrintUrlByOrder($id)
	{
		$payment = Y::command()
			->select('payment_id, payment_system_id, payment_accept_info')
			->from(BillingPayment::model()->tableName())
			->leftJoin(BillingInvoice::model()->tableName(), 'payment_invoice_id=invoice_id')
			->where('invoice_order_id=:invoice_order_id', array(
				':invoice_order_id'=>(int)$id,
			))
			->order('payment_status DESC, payment_id DESC')
			->limit(1)
			->queryRow();
		
		$system = Y::command()
			->select('system_code')
			->from(BillingSystem::model()->tableName())
			->where('system_id=:system_id', array(
				':system_id'=>$payment['payment_system_id'],
			))
			->queryScalar();
		
		if($system!='BANK')
			return;
		
		$params = array(
			'do'=>'print',
			'payment_id'=>$payment['payment_id'],
		);
		if($payment['payment_accept_info'])
		{
			list($field, $val) = explode('=', $payment['payment_accept_info']);
			$params[$field] = $val;
		}
		
		return Yii::app()->getController()->createAbsoluteUrl('billing/pay/'.$system, $params);
		
//		http://happy-giraffe.ru/shop/billing/pay/BANK/do/print/requisite_id/1/payment_id/17/
	}
}
