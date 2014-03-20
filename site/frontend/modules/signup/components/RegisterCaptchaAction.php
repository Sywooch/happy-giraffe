<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 06/03/14
 * Time: 12:20
 * To change this template use File | Settings | File Templates.
 */

class RegisterCaptchaAction extends CaptchaExtendedAction
{
    public function validate($input,$caseSensitive){
        // open session, if necessary generate new code
        $this->getVerifyCode();
        // read result
        $session = Yii::app()->session;
        $name = $this->getSessionKey();
        $result = $session[$name . 'result'];
        // input always taken without whitespaces
        $input = preg_replace('/\s/','',$input);
        $valid = $caseSensitive ? strcmp($input, $result)===0 : strcasecmp(mb_strtolower($input, 'UTF8'), mb_strtolower($result, 'UTF8'))===0;
        // increase attempts counter, but not in case of ajax-client validation (that is always POST request having variable 'ajax')
        // otherwise captcha would be silently invalidated after entering the number of fields equaling to testlimit number
        if(empty($_POST['ajax'])){
            $name = $this->getSessionKey() . 'count';
            $session[$name] = $session[$name] + 1;
            if($valid || $session[$name] > $this->testLimit && $this->testLimit > 0){
                // generate new code also each time correctly entered
                $this->getVerifyCode(true);
            }
        }
        return $valid;
    }
}