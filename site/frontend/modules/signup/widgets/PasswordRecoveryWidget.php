<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 25/02/14
 * Time: 11:15
 * To change this template use File | Settings | File Templates.
 */

class PasswordRecoveryWidget extends CWidget
{
    public function run()
    {
        $model = new PasswordRecoveryForm();
        $this->render('PasswordRecoveryWidget', compact('model'));
    }
}