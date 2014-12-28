<?php

namespace site\frontend\modules\signup\models;

/**
 * @author Никита
 * @date 23/12/14
 */

class CaptchaForm extends \CFormModel
{
    public $verifyCode;

    public function rules()
    {
        return array(
            array('verifyCode', 'required'),
            array('verifyCode', 'CaptchaExtendedValidator', 'captchaAction' => '/signup/default/captcha', 'allowEmpty' => ! \CCaptcha::checkRequirements()),
        );
    }
} 