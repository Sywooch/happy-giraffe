<?php

class MailModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
		    'mail.models.*',
			'mail.components.*',
            'mail.components.messages.*',
            'mail.components.messages.system.*',
            'mail.components.senders.*',
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

    public static function externalImport()
    {
        $import = array(
            'site.frontend.modules.mail.models.*',
            'site.frontend.modules.mail.components.messages.*',
            'site.frontend.modules.mail.components.messages.system.*',
            'site.frontend.modules.mail.components.senders.*',
        );

        foreach ($import as $alias) {
            Yii::import($alias);
        }
    }
}
