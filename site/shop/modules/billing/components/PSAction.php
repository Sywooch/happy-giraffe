<?php
class PSAction extends CAction
{
	public $psCode;
	public $handledPayment;

	function run($do='create')
	{
		if (method_exists($this,$method="do{$do}")) {
			$this->$method();
		} else {
			$this->Fail404();
		}
	}
	function getSystem()
	{
		$system	 = BillingSystem::model()->findByAttributes(array('system_code'=>$this->psCode, 'system_status'=>1));
		if (!$system) $this->Fail404();
		return $system;
	}

	function render($view, $vars)
	{
		return $this->controller->render($this->psCode.'/'.$view, $vars);
	}

	function Fail404()
	{
		throw new CHttpException(404,Yii::t('controllers','Page not found.'));
	}
	function Fail500($msg='Internal server error')
	{
		throw new CHttpException(500,Yii::t('controllers',$msg));
	}
	function Fail($errcode)
	{
		echo $errcode;
		Yii::app()->end();
	}

}
?>
