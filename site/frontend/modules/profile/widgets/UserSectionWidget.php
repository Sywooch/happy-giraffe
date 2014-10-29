<?php
/**
 * @author Никита
 * @date 28/10/14
 */

class UserSectionWidget extends CWidget
{
    /** @var \User */
    public $user;

    public function run()
    {
        if (Yii::app()->controller instanceof LiteController && Yii::app()->user->id != $this->user->id) {
            $this->render('UserSectionWidget');
        }
    }
} 