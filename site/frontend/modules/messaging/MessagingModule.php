<?php

class MessagingModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'messaging.models.*',
			'messaging.components.*',
		));

        Yii::app()->clientScript
            ->registerScriptFile('/javascripts/knockout-2.2.1.js')
            ->registerScriptFile('/javascripts/messaging.js')
            ->registerScriptFile('/javascripts/im.js')
            ->registerScriptFile('/ckeditor/ckeditor.js')
            ->registerScriptFile('/javascripts/knockout.mapping-latest.js')
            ->registerScriptFile('/javascripts/jquery.powertip.js')
        ;
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
