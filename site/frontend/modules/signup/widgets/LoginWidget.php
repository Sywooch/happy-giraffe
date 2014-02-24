<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/02/14
 * Time: 16:56
 * To change this template use File | Settings | File Templates.
 */

class LoginWidget extends CWidget
{
    public function run()
    {
        $model = new LoginForm();
        $this->render('LoginWidget', compact('model'));
    }
}