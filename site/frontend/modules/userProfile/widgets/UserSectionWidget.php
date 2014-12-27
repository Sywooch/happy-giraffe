<?php

namespace site\frontend\modules\userProfile\widgets;

/**
 * @author Никита
 * @date 28/10/14
 */

class UserSectionWidget extends \CWidget
{
    public $user;
    public $showToOwner = false;

    public function run()
    {
        if (! $this->show()) {
            return;
        }
        $this->render('UserSectionWidget', array('user' => $this->user));
    }

    protected function show()
    {
        return $this->showToOwner || ($this->user->id != \Yii::app()->user->id);
    }
} 