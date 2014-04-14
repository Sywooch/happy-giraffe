<?php
/**
 * Виджет окна генерации нового пароля
 */

class PasswordRecoveryWidget extends CWidget
{
    public function run()
    {
        $model = new PasswordRecoveryForm();
        $this->render('PasswordRecoveryWidget', compact('model'));
    }
}