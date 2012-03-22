<?php
class LoginWidget extends CWidget
{
    public $onlyForm = false;

    public function run()
    {
        if(Yii::app()->user->isGuest || $this->onlyForm)
        {
            $model = new User;
            $this->render('form', array('model' => $model));
        }
        else
        {
            $this->render('cabinet');
        }
    }
}
