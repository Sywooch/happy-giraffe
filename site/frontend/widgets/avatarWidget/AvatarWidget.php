<?php

class AvatarWidget extends CWidget
{
	public $user;
    public $size = 'ava';
    public $withMail;
    public $small = false;
    public $friendButton = false;
    public $sendButton = true;
	
	public function run()
	{
		$this->render('view');
	}

}