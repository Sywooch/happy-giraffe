<?php

class AvatarWidget extends CWidget
{
	public $user;
    public $size = 'ava';
    public $withMail;
	
	public function run()
	{
		$this->render('AvatarWidget');
	}

}