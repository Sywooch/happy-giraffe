<?php
/**
 * Author: alexk984
 * Date: 10.01.13
 */
class HEmailSender extends CApplicationComponent
{
    const LIST_OUR_USERS = 'our_users';
    const LIST_MAILRU_USERS = 'mailru_users';

    public $subjects = array(
        'newMessages' => 'Вам пришли сообщения - Весёлый Жираф',
        'passwordRecovery' => 'Напоминание пароля - Весёлый Жираф',
        'confirmEmail' => 'Подтверждение e-mail - Весёлый Жираф',
        'resendConfirmEmail' => 'Подтверждение e-mail - Весёлый Жираф',
    );

    public function send($user, $action, $params = array(), $controller = null)
    {
        if (is_int($user))
            $user = User::model()->findByPk($user);
        if (is_string($user))
            $user = User::model()->findByAttributes(array('email' => $user));
        if ($user === null)
            return false;

        if ($controller === null)
            $controller = Yii::app()->controller;

        $params['user'] = $user;
        $html = $controller->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . $action . '.php', $params, true);

        return ElasticEmail::send($user->email, $this->subjects[$action], $html, 'noreply@happy-giraffe.ru', 'Весёлый Жираф');
    }

    public function addContact($email, $first_name, $last_name, $list)
    {
        ElasticEmail::addContact($email, $first_name, $last_name, $list);
    }
}
