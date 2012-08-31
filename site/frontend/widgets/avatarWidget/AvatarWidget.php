<?php

class AvatarWidget extends CWidget
{
	public $user;
    public $size = 'ava';
    public $withMail;
    public $small = false;
    public $friendRequest = false;
    public $friendButton = false;
    public $sendButton = true;
    public $filled = false;
    public $location = true;
    public $nav = false;
    public $status = false;
    public $hideLinks = false;

	public function run()
	{
        if ($this->user->id != User::HAPPY_GIRAFFE) {
		    $this->render('view');
        }
	}
}