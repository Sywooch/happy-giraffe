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
        if (Yii::app()->controller instanceof LiteController && Yii::app()->controller->isPersonalArea()) {
            $this->render('UserSectionWidget');
        }
    }
} 