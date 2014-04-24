<?php
/**
 * Виджет окна регистрации
 */

class RegisterWidget extends CWidget
{
    const STEP_REG1 = 0;
    const STEP_REG2 = 1;
    const STEP_EMAIL1 = 2;
    const STEP_EMAIL2 = 3;
    const STEP_PHOTO = 4;

    protected $maxAge = 90;
    protected $minAge = 16;

    public function run()
    {
        $modelStep1 = new RegisterFormStep1();
        $modelStep2 = new RegisterFormStep2();
        $resendConfirm = new ResendConfirmForm();
        $avatarUpload = new AvatarUploadForm();
        $minYear = date('Y') - 90;
        $maxYear = date('Y') - 16;
        $c = new ReflectionClass($this);
        $constants = $c->getConstants();
        $mailServices = $this->getMailServices();
        $countries = GeoCountry::getCountries();
        $newUser = Yii::app()->user->getState('newUser');
        if (Yii::app()->user->hasState('newUser'))
            Yii::app()->user->setState('newUser', null);
        $json = compact('minYear', 'maxYear', 'constants', 'mailServices', 'countries', 'newUser');
        $this->render('RegisterWidget', compact('modelStep1', 'modelStep2', 'resendConfirm', 'avatarUpload', 'json'));
    }

    /**
     * Возвращает строку для js, логическое значение которой соответствует необходимости автоматически открыть всплывающее окно регистрации
     * @return string
     */
    public function autoOpen()
    {
        return 'false';

        $showForm = ! Yii::app()->request->cookies->contains('registerWindowShown') && ! Yii::app()->request->cookies->contains('not_guest') && Yii::app()->user->getState('viewsCount') == 2;
        if ($showForm) {
            Yii::app()->request->cookies['registerWindowShown'] = new CHttpCookie('registerWindowShown', 1);
            return 'true';
        }
        return 'false';
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
                'name' => 'Яндекс',
                'url' => 'https://mail.yandex.ru/',
                'domains' => array(
                    'yandex.ru',
                    'ya.ru',
                ),
            ),
            array(
                'name' => 'Яндекс',
                'url' => 'https://mail.yandex.ua/',
                'domains' => array(
                    'yandex.ua',
                    'ya.ua',
                ),
            ),
            array(
                'name' => 'Gmail',
                'url' => 'https://mail.google.com/',
                'domains' => array(
                    'gmail.com'
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
                'name' => 'MSN',
                'url' => 'https://login.live.com/',
                'domains' => array(
                    'outlook.com',
                    'hotmail.com',
                ),
            ),
            array(
                'name' => 'ukr.net',
                'url' => 'http://mail.ukr.net/',
                'domains' => array(
                    'ukr.net',
                ),
            ),
            array(
                'name' => 'Yahoo',
                'url' => 'https://login.yahoo.com/',
                'domains' => array(
                    'yahoo.com',
                ),
            ),
        );
    }


}