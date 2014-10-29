<?php
/**
 * @author Никита
 * @date 28/10/14
 */

class UserSectionWidget extends CWidget
{
    public function run()
    {
        $controller = Yii::app()->controller;
        $showWidget = $controller instanceof PersonalAreaController && ! $controller->isPersonalArea() && ($user = $controller->pageOwner);
        if ($showWidget) {
            $this->render('UserSectionWidget', compact('user'));
        }
    }
} 