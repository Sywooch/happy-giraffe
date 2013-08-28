<?php

class UserCoreWidget extends CWidget
{
    /**
     * @var User
     */
    public $user;
    public $uniqid;

    protected $isMyProfile = false;
    protected $visible = true;
    protected $viewFile = null;

    public function init()
    {
        $this->isMyProfile = $this->user->id == Yii::app()->user->id;
        $this->uniqid = uniqid();
    }

    public function run()
    {
        if ($this->visible) {
            if($this->viewFile === null)
                $this->viewFile = get_class($this);
            $this->render($this->viewFile, array(
                'user' => $this->user,
                'isMyProfile' => $this->isMyProfile,
            ));
        }
    }
}
