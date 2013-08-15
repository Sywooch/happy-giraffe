<?php

class UserAvatarWidget extends CWidget
{
    /**
     * @var User
     */
    public $user;
    /**
     * @var string
     */
    public $size = 72;
    public $location = false;
    public $age = false;

	public function run()
	{
        $this->render($this->size);
	}
}