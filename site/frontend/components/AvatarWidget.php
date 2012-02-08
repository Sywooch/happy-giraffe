<?php

class AvatarWidget extends CWidget
{
	public $user;
	
	public function run()
	{
		$this->render('AvatarWidget', array(
			'user' => $this->user,
		));
	}

}