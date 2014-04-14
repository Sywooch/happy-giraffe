<?php
/**
 * Капча для виджета регистрации
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