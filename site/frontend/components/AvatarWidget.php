<?php

class AvatarWidget extends CWidget
{
	public $user;
    public $size = 'ava';
	
	public function run()
	{
		$this->render('AvatarWidget', array(
			'user' => $this->user,
            'size' => $this->size,
		));
	}

}