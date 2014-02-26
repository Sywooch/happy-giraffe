<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 20/02/14
 * Time: 11:44
 * To change this template use File | Settings | File Templates.
 */

class RegisterWidget extends CWidget
{
    const STEP_REG1 = 0;
    const STEP_REG2 = 1;
    const STEP_EMAIL1 = 2;
    const STEP_EMAIL2 = 3;

    protected $maxAge = 90;
    protected $minAge = 16;

    public function run()
    {
        Yii::app()->clientScript->registerPackage('ko_registerWidget');
        $modelStep1 = new RegisterFormStep1();
        $modelStep2 = new RegisterFormStep2();
        $resendConfirm = new ResendConfirmForm();
        $minYear = date('Y') - 90;
        $maxYear = date('Y') - 16;
        $c = new ReflectionClass($this);
        $constants = $c->getConstants();
        $mailServices = $this->getMailServices();
        $json = compact('minYear', 'maxYear', 'constants', 'mailServices');
        $this->render('RegisterWidget', compact('modelStep1', 'modelStep2', 'resendConfirm', 'json'));
    }

    protected function getMailServices()
    {
        return array(
            array(
                'name' => 'Mail.ru',
                'url' => 'https://e.mail.ru/',
                'domains' => array(
                    'mail.ru',
                    'bk.ru',
                    'list.ru',
                    'inbox.ru',
                ),
            ),
            array(
                'name' => 'Gmail',
                'url' => 'https://mail.google.com/',
                'domains' => array(
                    'gmail'
                ),
            ),
            array(
                'name' => 'Rambler',
                'url' => 'https://mail.rambler.ru/',
                'domains' => array(
                    'rambler.ru',
                    'lenta.ru',
                    'myrambler.ru',
                    'autorambler.ru',
                    'ro.ru',
                    'r0.ru',
                ),
            ),
            array(
                'name' => 'Весёлый Жираф',
                'url' => 'http://www.happy-giraffe.ru/',
                'domains' => array(
                    'happy-giraffe.ru',
                ),
            ),
        );
    }


}