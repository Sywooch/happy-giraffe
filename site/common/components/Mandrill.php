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
        $commonData = array(
            'key' => $this->apiKey,
            'message' => array(
                'from_email' => 'noreply@happy-giraffe.ru',
                'from_name' => 'Весёлый Жираф',
                'to' => array(
                    array(
                        'email' => $user->email,
                        'name' => $user->fullName,
                    ),
                ),
            ),
        );
        if (in_array($action, array('newMessages'))) {
            $commonData['template_name'] = $action;
            $apiAction = 'messages/send-template.json';
        } else {
            $commonData['message']['html'] = file_get_contents(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . $action . '.php');
            $apiAction = 'messages/send.json';
        }
        $data = CMap::mergeArray($commonData, $this->$action($user, $params));
        $res = $rest->post($apiAction, $data);
        $res = CJSON::decode($res);

        if (isset($res[0]['status']))
            return $res[0]['status'] != 'error';
        else
            return 'error';
    }

    public function sendAlex($subject, $text)
    {
        $rest = new RESTClient;
        $rest->initialize(array('server' => 'https://mandrillapp.com/api/1.0/'));
        $data = array(
            'key' => $this->apiKey,
            'message' => array(
                'from_email' => 'noreply@happy-giraffe.ru',
                'from_name' => 'Весёлый Жираф',
                'subject' => $subject,
                'to' => array(
                    array(
                        'email' => 'alexk984@gmail.com',
                        'name' => 'Alex',
                    ),
                ),
                'html'=>$text
            ),
        );
        $res = $rest->post('messages/send.json', $data);
        var_dump($res);
    }

    public function newMessages($user, $params)
    {
        return array(
            'template_content' => array(
                array(
                    'name' => 'messages',
                    'content' => $params['messages'],
                ),
            ),
            'message' => array(
                'subject' => 'Вам пришли сообщения - Весёлый Жираф',
                'global_merge_vars' => array(
                    array(
                        'name' => 'USERNAME',
                        'content' => $user->fullName,
                    ),
                    array(
                        'name' => 'TOKEN',
                        'content' => $params['token']->content,
                    ),
                ),
            ),
        );
    }

    public function passwordRecovery($user, $params)
    {
        return array(
            'message' => array(
                'subject' => 'Напоминание пароля - Весёлый Жираф',
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
                'subject' => 'Подтверждение e-mail - Весёлый Жираф',
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

    public function resendConfirmEmail($user, $params)
    {
        return array(
            'message' => array(
                'subject' => 'Подтверждение e-mail - Весёлый Жираф',
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
                        'name' => 'CODE',
                        'content' => $params['code'],
                    ),
                ),
            ),
        );
    }
}
