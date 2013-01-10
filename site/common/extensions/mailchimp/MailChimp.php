<?php
/**
 * @property MCAPI $api
 *
 */
class MailChimp extends CApplicationComponent
{
    const WEEKLY_NEWS_LIST_ID = 'd8ced52317';
    const WEEKLY_NEWS_TEST_LIST_ID = 'ee63e4d551';
    const CONTEST_LIST = 'dc4cb268fc';
    const CONTEST_PARC_LIST = '5fcdbab25f';

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

    public function updateUsers()
    {
        echo 'dfhsgdj';
        //пользователи которые зарегистрировались после 1 мая + наши сотрудники
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'mail_subs'
        );
        $criteria->condition = '(t.group < 5 AND t.group > 0 OR t.group = 6) OR (t.group = 0 AND t.register_date >= "2012-05-01 00:00:00")';
        $criteria->scopes = array('active');
        $criteria->limit = 100;
        $users = array(1);

        $i = 0;
        $unsubscribe_mails = array();
        while (!empty($users)) {
            $criteria->offset = $i * 100;
            $users = User::model()->findAll($criteria);
            $options = array();
            foreach ($users as $user) {
                if ($user->mail_subs === null || $user->mail_subs->weekly_news == 1)
                    $options[] = $this->getUserOptions($user);
                else
                    $unsubscribe_mails [] = $user->email;
            }

            $this->api->listBatchSubscribe($this->list, $options, false, true, false);
            $i++;
            echo ($i * 100) . "\n";
        }

        echo 'unsubscribes: ';
        print_r($unsubscribe_mails);
        $this->api->listBatchUnsubscribe($this->list, $unsubscribe_mails, false, false, false);
    }

    public function updateMailruUsers()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->condition = 'id > 484847';

        $users = array(1);
        $last_id = 0;
        while (!empty($users)) {
            $users = MailruUser::model()->findAll($criteria);
            $options = array();
            foreach ($users as $user) {
                if (User::model()->findByAttributes(array('email'=>$user->email)) === null){
                    $options[] = array(
                        'EMAIL' => $user->email,
                        'FNAME' => $user->name,
                        'LNAME' => '',
                    );
                    echo $user->email.'<br>';
                    $last_id = $user->id;
                }
            }

            $this->list = self::CONTEST_LIST;
            $this->api->listBatchSubscribe($this->list, $options, false, true, false);

            $criteria->offset += 100;

            if ($criteria->offset >= 50000)
                $users = null;
        }

        echo $last_id;
    }

    public function deleteRegisteredFromContestList()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->condition = 'id > 55000';
        $criteria->offset = 0;

        $users = array(1);
        while (!empty($users)) {
            $users = User::model()->findAll($criteria);
            $options = array();
            foreach ($users as $user)
                if (!empty($user->email))
                $options[] = $user->email;

            $this->list = self::CONTEST_LIST;
            $this->api->listBatchUnsubscribe($this->list, $options, true, false, false);

            $criteria->offset += 100;
            echo $criteria->offset."\n";
        }
    }

    public function updateContestUsers()
    {
        Yii::import('site.frontend.modules.contest.models.*');
        Yii::import('site.frontend.helpers.*');

        $works = ContestWork::model()->findAll('contest_id=4');
        $options = array();
        foreach ($works as $work) {
            $options[] = array(
                'EMAIL' => $work->author->email,
                'FNAME' => $work->author->first_name,
                'LNAME' => $work->author->last_name,
                'IMGSRC'=> $work->photoAttach->photo->getPreviewUrl(210, null, Image::WIDTH),
                'TITLE' => $work->title,
                'PLACE' => $work->position,
                'SCORES' => $work->rate,
                'SCORESWORD' => HDate::GenerateNoun(array('балл', 'балла', 'баллов'), $work->rate),
                'LINK' => trim($work->url, '.'),
            );
            //echo $work->author->email.'\n';
        }

        echo count($options)."\n";

        $this->list = self::CONTEST_PARC_LIST;
        $this->api->listBatchSubscribe($this->list, $options, false, true, false);
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
            $criteria->offset = $i * 100;
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
