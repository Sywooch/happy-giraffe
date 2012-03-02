<?php

class AvatarWidget extends CWidget
{
	public $user;
    public $withMail = true;
	
	public function run()
	{
        Yii::import('site.frontend.modules.geo.models.GeoCountry');
		$this->render('AvatarWidget', array(
			'user' => $this->user,
		));
	}

}