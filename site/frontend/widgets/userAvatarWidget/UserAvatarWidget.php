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
    public $size = 'medium';

	public function run()
	{
        $this->render($this->size);
	}
}