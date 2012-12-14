<?php

class WhatsNewModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'whatsNew.components.*',
            'application.modules.contest.models.*',
            'application.widgets.activeUsersWidget.ActiveUsersWidget'
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
