<?php

namespace site\frontend\modules\photo;

class PhotoModule extends \CWebModule
{
    public $controllerNamespace = '\site\frontend\modules\photo\controllers';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'photo.models.*',
			'photo.components.*',
		));

        /** @var \ClientScript $cs */
        $cs = \Yii::app()->clientScript;
        $cs->useAMD = true;
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
