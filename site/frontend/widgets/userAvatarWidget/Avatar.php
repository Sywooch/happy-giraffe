<?php

class Avatar extends CWidget
{
    const SIZE_MICRO = 24;
    const SIZE_MEDIUM = 72;
    const SIZE_LARGE = 200;

    /**
     * @var User
     */
    public $user;
    /**
     * @var string
     */
    public $size = self::SIZE_MEDIUM;
    public $location = false;
    public $age = false;
    public $message_link = true;
    public $blog_link = true;

	public function run()
	{
        $this->render($this->size);
	}
}