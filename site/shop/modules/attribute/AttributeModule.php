<?php

class AttributeModule extends CWebModule
{
	public $prefix = '';

	public $defaultController = 'attribute';
	
	public $theme = '';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
//			'application.models.*',
			'attribute.models.*',
			'attribute.components.*',
		));
		
		Yii::app()->theme = $this->theme;

//		Yii::app()->db->tablePrefix = $this->prefix;
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
}
