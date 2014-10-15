<?php

namespace site\frontend\modules\photo;

class PhotoModule extends \CWebModule
{
    public $quality;
    public $types;

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
//        $cs = \Yii::app()->clientScript;
//        $cs->useAMD = true;

        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
            'showErrors' => YII_DEBUG,
        ));
	}

    public function beforeControllerAction($controller, $action)
    {
        $package = \Yii::app()->user->isGuest ? 'lite_photo' : 'lite_photo_user';
        \Yii::app()->clientScript->registerPackage($package);
        \Yii::app()->clientScript->useAMD = true;
        return parent::beforeControllerAction($controller, $action);
    }

}
