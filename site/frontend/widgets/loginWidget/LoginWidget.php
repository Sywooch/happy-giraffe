<?php
class LoginWidget extends CWidget
{
    public function run()
    {
        return;
        if (Yii::app()->user->isGuest) {
            $model = new User;
            $this->render('form', array('model' => $model));
        } else {
            $this->render('cabinet');
        }
    }
}
