<?php
/**
 * Author: choo
 * Date: 02.08.2012
 */
Yii::import('site.common.extensions.restcurl.*');

class Mandrill extends CApplicationComponent
{
    public $apiKey;

    public function send($user, $action, $params = array())
    {
        if (is_int($user))
            $user = User::model()->findByPk($user);
        if (is_string($user))
            $user = User::model()->findByAttributes(array('email' => $user));
        if ($user === null)
            return false;

        $rest = new RESTClient;
        $rest->initialize(array('server' => 'https://mandrillapp.com/api/1.0/'));
        $generalData = array(
            'key' => $this->apiKey,
            'message' => array(
                'html' => file_get_contents(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . $action . '.php'),
                'from_email' => 'noreply@happy-giraffe.ru',
                'to' => array(
                    array(
                        'email' => $user->email,
                        'name' => $user->fullName,
                    ),
                ),
            ),
        );
        $data = CMap::mergeArray($generalData, $this->$action($user, $params));
        $res = $rest->post('messages/send.json', $data);
        $res = CJSON::decode($res);
        return $res[0]['status'] != 'error';
    }

    public function passwordRecovery($user, $params)
    {
        return array(
            'message' => array(
                'subject' => 'Напоминание пароля',
                'global_merge_vars' => array(
                    array(
                        'name' => 'USERNAME',
                        'content' => $user->fullName,
                    ),
                    array(
                        'name' => 'EMAIL',
                        'content' => $user->email,
                    ),
                    array(
                        'name' => 'PASSWORD',
                        'content' => $params['password'],
                    ),
                ),
            ),
        );
    }

    public function confirmEmail($user, $params)
    {
        return array(
            'message' => array(
                'subject' => 'Регистрация на Весёлом Жирафе',
                'global_merge_vars' => array(
                    array(
                        'name' => 'USERNAME',
                        'content' => $user->fullName,
                    ),
                    array(
                        'name' => 'EMAIL',
                        'content' => $user->email,
                    ),
                    array(
                        'name' => 'USERID',
                        'content' => $user->id,
                    ),
                    array(
                        'name' => 'PASSWORD',
                        'content' => $params['password'],
                    ),
                    array(
                        'name' => 'CODE',
                        'content' => $params['code'],
                    ),
                ),
            ),
        );
    }
}
