<?php

namespace site\frontend\modules\userProfile\widgets;

/**
 * @author Никита
 * @date 28/10/14
 */

class UserSectionWidget extends \CWidget
{
    public $user;

    public function run()
    {
        if ($this->user->id != \Yii::app()->user->id) {
            $this->render('UserSectionWidget', array('user' => $this->user));
        }
    }
} 