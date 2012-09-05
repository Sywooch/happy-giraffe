<?php
/**
 * @property MCAPI $api
 *
 */
class MailChimp extends CApplicationComponent
{
    const WEEKLY_NEWS_LIST_ID = 'd8ced52317';
    const WEEKLY_NEWS_TEST_LIST_ID = 'ee63e4d551';

    public $apiKey;
    public $list;
    public $_api;

    /**
     * @return MCAPI
     */
    public function getApi()
    {
        if (!$this->_api) {
            Yii::import('site.common.extensions.mailchimp.vendors.MCAPI', true);
            if (isset($_ENV['COMPANY'])) {
                $this->apiKey = $this->list[$_ENV['COMPANY']];
            }
            $this->_api = new MCAPI($this->apiKey);
        }
        return $this->_api;
    }

    /**
     * @param User $user
     */
    public function saveUser($user)
    {
        $options = array($this->getUserOptions($user));
        $this->api->listBatchSubscribe($this->list, $options, false, true, false);
    }

    public function updateUsersTest()
    {
        //пользователи которые зарегистрировались после 1 мая + наши сотрудники
        $criteria = new CDbCriteria;
        $criteria->condition = '(t.group = 4)';
        $criteria->scopes = array('active');
        $criteria->limit = 100;
        $users = array(1);

        $i = 0;
        while (!empty($users)) {
            $criteria->offset = $i*100;
            $users = User::model()->findAll($criteria);
            $options = array();
            foreach ($users as $user)
                $options[] = $this->getUserOptions($user);

            $res = $this->api->listBatchSubscribe($this->list, $options, false, true, false);
            echo $res;
            $i++;
        }
    }

    public function updateUsers()
    {
        //пользователи которые зарегистрировались после 1 мая + наши сотрудники
        $criteria = new CDbCriteria;
        $criteria->condition = '(t.group < 5 AND t.group > 0) OR (t.group = 0 AND t.register_date >= "2012-05-01 00:00:00")';
        $criteria->scopes = array('active');
        $criteria->limit = 100;
        $users = array(1);

        $i = 0;
        while (!empty($users)) {
            $criteria->offset = $i*100;
            $users = User::model()->findAll($criteria);
            $options = array();
            foreach ($users as $user)
                $options[] = $this->getUserOptions($user);

            $res = $this->api->listBatchSubscribe($this->list, $options, false, true, false);
            echo $res;
            $i++;
        }
    }

    public function deleteUsers()
    {
        //пользователи которые зарегистрировались после 1 мая + наши сотрудники
        $criteria = new CDbCriteria;
        $criteria->condition = '(t.group < 5 AND t.group > 0) OR (t.group = 0 AND t.register_date >= "2012-05-01 00:00:00")';
        $criteria->scopes = array('active');
        $criteria->limit = 100;
        $users = array(1);

        $i = 0;
        while (!empty($users)) {
            $criteria->offset = $i*100;
            $users = User::model()->findAll($criteria);
            $options = array();
            foreach ($users as $user)
                $options[] = $user->email;

            $res = $this->api->listBatchUnSubscribe($this->list, $options, true, false, false);
            echo $res;
            $i++;
        }
    }

    public function getLists()
    {
        $res = $this->api->lists();
        var_dump($res);
        foreach ($res['data'] as $list) {
            echo $list['id'] . '<br>';
        }
    }

    /**
     * @param User $user
     * @return array
     */
    private function getUserOptions($user)
    {
        $options = array(
            'EMAIL' => $user->email,
            'FNAME' => $user->first_name,
            'LNAME' => $user->last_name,
            'GENDER' => $user->gender,
        );
        if ($user->age !== null)
            $options['AGE'] = $user->age;
        return $options;
    }

    public function sendToEmail($email, $model, $action)
    {
        if (($template = MailTemplate::model()->findByAction($action)) == null)
            return;
        $body = $template->parse($model, 'body');
        $subject = $template->parse($model, 'subject');
        $segmentGroups = array(
            'match' => 'any',
            'conditions' => array(
                array(
                    'field' => 'EMAIL',
                    'op' => 'eq',
                    'value' => $email),
            )
        );
        return $this->send($segmentGroups, $subject, $body);
    }

    public function sendToGroup($subject, $body)
    {
        return $this->send(null, $subject, $body);
    }

    public function send($segmentGroups, $subject, $body)
    {
        $opts = array(
            'list_id' => $this->list,
            'from_email' => 'support@happy-giraffe.ru',
            'from_name' => 'Веселый Жираф',
            'tracking' => array('opens' => true, 'html_clicks' => true, 'text_clicks' => false),
            'authenticate' => true,
            'subject' => $subject,
            'title' => $subject,
        );

        $content = array(
            'html' => $body,
        );

        $campaignId = $this->api->campaignCreate('regular', $opts, $content, $segmentGroups);
        if ($campaignId)
            return $this->api->campaignSendNow($campaignId);
        return false;
    }

    public function sendWeeklyNews($subject, $body)
    {
        $opts = array(
            'list_id' => $this->list,
            'from_email' => 'support@happy-giraffe.ru',
            'from_name' => 'Веселый Жираф',
            'template_id' => 24517,
            'tracking' => array('opens' => true, 'html_clicks' => true, 'text_clicks' => false),
            'authenticate' => true,
            'subject' => $subject,
            'title' => $subject,
            'generate_text' => true,
        );

        $content = array(
            'html_content' => $body,
        );

        $campaignId = $this->api->campaignCreate('regular', $opts, $content);
        if ($campaignId)
            return $this->api->campaignSendNow($campaignId);
        return false;
    }
}
