<?php

namespace site\frontend\modules\iframe\modules\family;

class FamilyModule extends \CWebModule
{
    public $controllerNamespace = '\site\frontend\modules\iframe\modules\family\controllers';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'iframe.modules.family.models.*',
			'iframe.modules.family.components.*',
		));

        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
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
}
