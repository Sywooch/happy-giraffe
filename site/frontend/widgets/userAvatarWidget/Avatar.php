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
    public $url;
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
        if ($this->user->deleted)
            $this->url = 'javascript:;';
        else
            $this->url = $this->user->getUrl();

        $this->render($this->size);
	}
}