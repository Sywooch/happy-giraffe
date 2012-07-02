<?php

class CookModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'cook.models.*',
			'cook.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if ($controller->id != 'recipe' || $action->id != 'view')
                Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
			return true;
		}
		else
			return false;
	}
}
