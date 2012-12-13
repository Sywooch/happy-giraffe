<?php

class MailCommand extends CConsoleCommand
{
    public function actionIndex()
    {

    }

    public function actionWeeklyNews()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.common.extensions.mailchimp.*');

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

    public function actionNewMessages()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.im.models.*');
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.modules.im.components.*');
        Yii::import('site.common.models.mongo.*');

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
                        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.newMessages') . '.php', compact('dialogUsers', 'unread', 'user', 'token'), true);
                        Yii::app()->mandrill->send($user, 'newMessages', array('messages' => $contents, 'token' => $token));
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

    public function actionContest()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.common.extensions.mailchimp.*');

        $subject = 'Фотоконкурс «Мама и Я» на «Веселом Жирафе»!';
        $opts = array(
            'list_id' => MailChimp::CONTEST_LIST,
            'from_email' => 'support@happy-giraffe.ru',
            'from_name' => 'Веселый Жираф',
            'template_id' => 49097,
            'tracking' => array('opens' => true, 'html_clicks' => true, 'text_clicks' => false),
            'authenticate' => true,
            'subject' => $subject,
            'title' => $subject,
            'generate_text' => true,
        );

        $content = array(
            'html_content' => '',
        );

        $campaignId = Yii::app()->mc->api->campaignCreate('regular', $opts, $content);
        if ($campaignId)
            return Yii::app()->mc->api->campaignSendNow($campaignId);
        return false;
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
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');

        Yii::app()->mc->updateUsers();
    }

    public function actionDeleteUsers()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');

        Yii::app()->mc->deleteRegisteredFromContestList();
    }

    public function actionTest()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.common.models.mongo.*');

        $articles = Favourites::model()->getWeekPosts();

        echo $articles[0]->url;
    }

    public function actionTestMessage()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.im.models.*');
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.modules.im.components.*');
        Yii::import('site.common.models.mongo.*');

        $user = User::getUserById(10);
        $token = UserToken::model()->generate($user->id, 86400);
        $dialogUsers = Im::model($user->id)->getUsersWithNewMessages();
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.newMessages') . '.php', compact('dialogUsers', 'unread', 'user', 'token'), true);
        Yii::app()->mandrill->send($user, 'newMessages', array('messages' => $contents, 'token' => $token));
    }

    public function actionTestWeekly()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.common.extensions.mailchimp.*');

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
}

