<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 26/02/14
 * Time: 13:35
 * To change this template use File | Settings | File Templates.
 */

class ResendConfirmForm extends CFormModel
{
    public $email;
    public $verifyCode;

    public function rules()
    {
        return array(
            array('email, verifyCode', 'required'),
            array('email', 'email'),
        );
    }
}