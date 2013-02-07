<?php

class MailCommand extends CConsoleCommand
{
    public function beforeAction($action)
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.im.models.*');
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.modules.im.components.*');
        Yii::import('site.common.models.mongo.*');

        return true;
    }

    public function actionWeeklyNews()
    {
        //check generated url
        if (Yii::app()->createUrl('site/index') != './') {
            echo Yii::app()->createUrl('site/index') . ' - url failed';
            return false;
        }

        $articles = Favourites::model()->getWeekPosts();
        if (count($articles) < 6)
            Yii::app()->end();
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);
        $vals = Yii::app()->mc->sendWeeklyNews('Веселый Жираф - самое интересное за неделю', $contents);

        if (Yii::app()->mc->api->errorCode) {
            echo "Batch Subscribe failed!\n";
            echo "code:" . Yii::app()->mc->api->errorCode . "\n";
            echo "msg :" . Yii::app()->mc->api->errorMessage . "\n";
        } else {
            echo "added:   " . $vals['add_count'] . "\n";
            echo "updated: " . $vals['update_count'] . "\n";
            echo "errors:  " . $vals['error_count'] . "\n";
        }
    }

    public function actionWeeklyNews2()
    {
        //check generated url
        if (Yii::app()->createUrl('site/index') != './') {
            echo Yii::app()->createUrl('site/index') . ' - url failed';
            return false;
        }

        $articles = Favourites::model()->getWeekPosts();
        if (count($articles) < 6)
            Yii::app()->end();
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);
        Yii::app()->mc->sendWeeklyNews('Веселый Жираф - самое интересное за неделю', $contents, MailChimp::CONTEST_LIST, false);
    }

    public function actionNewMessages()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $criteria->condition = 'deleted = 0 AND blocked = 0';

        //fired moderators
        $i = 0;
        $users = array(0);
        while (!empty($users)) {
            $criteria->offset = $i * 100;
            $users = User::model()->findAll($criteria);
            foreach ($users as $user) {
                $unread = Im::model($user->id)->getUnreadMessagesCount($user->id);
                if ($unread > 0) {

                    $m_criteria = new EMongoCriteria;
                    $m_criteria->type('==', MailDelivery::TYPE_IM);
                    $m_criteria->user_id('==', (int)$user->id);
                    $model = MailDelivery::model()->find($m_criteria);

                    if ($model === null || $model->needSend()) {
                        $token = UserToken::model()->generate($user->id, 86400);
                        $dialogUsers = Im::model($user->id)->getUsersWithNewMessages();
                        Yii::app()->email->send($user, 'newMessages', compact('dialogUsers', 'unread', 'user', 'token'), $this);
                        echo $user->id . "\n";

                        if ($model === null) {
                            $model = new MailDelivery();
                            $model->type = MailDelivery::TYPE_IM;
                            $model->user_id = (int)$user->id;
                        } else {
                            $model->last_send_time = time();
                        }
                        $model->save();
                    }
                }
            }
            echo ($i * 100) . " users checked\n";
            $i++;
        }
    }

    public function actionContestParticipants()
    {
        Yii::app()->mc->updateContestUsers();
    }

    public function actionMailruUsers()
    {
        Yii::app()->mc->updateMailruUsers();
    }

    public function actionUsers()
    {
        Yii::import('site.seo.models.mongo.*');
        $last_id = SeoUserAttributes::getAttribute('import_email_last_user_id' , 1);
        echo 'last_id: '.$last_id."\n";

        $criteria = new CDbCriteria;
        $criteria->with = array('mail_subs');
        $criteria->condition = '(t.group < 5 AND t.group > 0 OR t.group = 6) OR (t.group = 0 AND t.register_date >= "2012-05-01 00:00:00")';
        $criteria->scopes = array('active');
        $criteria->limit = 100;
        $criteria->condition = 'id > '.$last_id;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = User::model()->findAll($criteria);

            foreach ($models as $model){
                //Yii::app()->email->addContact($model->email, $model->first_name, $model->last_name, HEmailSender::LIST_OUR_USERS);
                SeoUserAttributes::setAttribute('import_email_last_user_id' , $model->id, 1);
            }

            $criteria->offset += 100;
        }
    }

    public function actionDeleteUsers()
    {
        Yii::app()->mc->deleteRegisteredFromContestList();
    }

    public function actionTestWeekly()
    {
        $articles = Favourites::model()->getWeekPosts();
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);
        $subject = 'Веселый Жираф - самое интересное за неделю - ТЕСТ';
        $opts = array(
            'list_id' => MailChimp::WEEKLY_NEWS_TEST_LIST_ID,
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
            'html_content' => $contents,
        );

        $campaignId = Yii::app()->mc->api->campaignCreate('regular', $opts, $content);
        if ($campaignId)
            return Yii::app()->mc->api->campaignSendNow($campaignId);
        return false;
    }

    public function actionTest()
    {
        Yii::app()->email->send(10, 'passwordRecovery', array(
            'code' => 12436,
            'password' => 325437
        ), $this);
    }

    public function actionTestNewMessages()
    {
        $user = User::getUserById(10);
        $unread = Im::model($user->id)->getUnreadMessagesCount($user->id);
        if ($unread > 0) {

            $m_criteria = new EMongoCriteria;
            $m_criteria->type('==', MailDelivery::TYPE_IM);
            $m_criteria->user_id('==', (int)$user->id);
            $model = MailDelivery::model()->find($m_criteria);

            if ($model === null || $model->needSend()) {
                $token = UserToken::model()->generate($user->id, 86400);
                $dialogUsers = Im::model($user->id)->getUsersWithNewMessages();

                Yii::app()->email->send(10, 'newMessages', compact('dialogUsers', 'unread', 'user', 'token'), $this);
            }
        }
    }

    public function actionUnsubList()
    {
        $file_name = 'F:/members_Photo_Post_6_6_bounces_Jan_16_2013.csv';
        $users = file_get_contents($file_name);
        $lines = explode("\n", $users);
        echo count($lines)."\n";

        $emails = array();
        foreach($lines as $line){
            $email = substr($line, 0, strpos($line, ','));
            $emails [] = $email;

            if (count($emails) >= 500){
                Yii::app()->mc->deleteUsers($emails);

                $emails = array();
            }
        }

        Yii::app()->mc->deleteUsers($emails);
    }
}