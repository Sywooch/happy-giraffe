<?php
/**
 * Виджет окна аутентификации
 */

class LoginWidget extends CWidget
{
    public function run()
    {
        $model = new LoginForm();
        $this->render('LoginWidget', compact('model'));
    }
}