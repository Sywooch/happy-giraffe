<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 26/02/14
 * Time: 13:51
 * To change this template use File | Settings | File Templates.
 */

class RegisterCaptcha extends CCaptcha
{
    public $imageOptions = array(
        'class' => 'popup-sign_capcha',
    );

    public $buttonOptions = array(
        'class' => 'popup-sign_tx-help',
    );

    public $buttonLabel = '<div class="ico-refresh"></div>Обновить';

    public $clickableImage = true;

    public $captchaAction = '/signup/register/captcha';
}