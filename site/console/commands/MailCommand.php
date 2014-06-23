<?php

class MailCommand extends CConsoleCommand
{
    public function beforeAction($action)
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.messaging.models.*');
        Yii::import('site.frontend.modules.messaging.components.*');
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.widgets.userAvatarWidget.Avatar');
        Yii::import('site.common.models.mongo.*');

        return true;
    }

    public function actionWeeklyNews()
    {
        //check generated url
        if (Yii::app()->createUrl('site/index') != './' && Yii::app()->createUrl('site/index') != '/') {
            echo Yii::app()->createUrl('site/index') . ' - url failed';
            return false;
        }

        $articles = Favourites::model()->getWeekPosts();
        echo count($articles) . "\n";
        if (count($articles) != 6)
            Yii::app()->end();
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);

        Yii::app()->email->sendCampaign($contents, HEmailSender::LIST_OUR_USERS);
    }

    public function actionTestWeekly()
    {
        $articles = Favourites::model()->getWeekPosts();
        if (empty($articles))
            $articles = CommunityContent::model()->findAll(array(
                'limit' => 6,
                'order' => 'id DESC',
            ));
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);

        Yii::app()->email->sendCampaign($contents, HEmailSender::LIST_TEST_LIST);
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
                $unread = MessagingManager::unreadMessagesCount($user->id);
                if ($unread > 0) {

                    $m_criteria = new EMongoCriteria;
                    $m_criteria->type('==', MailDelivery::TYPE_IM);
                    $m_criteria->user_id('==', (int)$user->id);
                    $model = MailDelivery::model()->find($m_criteria);

                    if ($model === null || $model->needSend()) {
                        $token = UserToken::model()->generate($user->id, 86400);
                        $dialogs = ContactsManager::getContactsByUserId($user->id, ContactsManager::TYPE_NEW, 10);
                        Yii::app()->email->send($user, 'newMessages', compact('dialogs', 'unread', 'user', 'token'), $this);
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

    public function actionMailruUsers()
    {
        Yii::import('site.seo.modules.mailru.models.*');

        Yii::app()->email->updateMailruUsers();
    }

    public function actionUsers()
    {
        Yii::app()->email->updateUserList();
    }

    public function actionInitGenderLists()
    {
        Yii::app()->email->initGenderLists();
    }

    public function actionDeleteUsers()
    {
        Yii::app()->email->deleteRegisteredFromContestList();
    }

    public function actionTestNewMessages()
    {
        $user = User::getUserById(12936);
        $unread = MessagingManager::unreadMessagesCount($user->id);
        echo 'unread: '.$unread."\n";
        if ($unread > 0) {
            $token = UserToken::model()->generate($user->id, 86400);
            $dialogs = ContactsManager::getContactsByUserId($user->id, ContactsManager::TYPE_NEW, 10);

            Yii::app()->email->send(12936, 'newMessages', compact('dialogs', 'unread', 'user', 'token'), $this);
        }
    }

    public function actionContestContinue()
    {
        Yii::import('site.frontend.modules.contest.models.*');
        Yii::import('site.frontend.helpers.*');

        $last_contest = Yii::app()->db->createCommand()->select('max(id)')->from(Contest::model()->tableName())->queryScalar();
        echo $last_contest."\n";
        $works = ContestWork::model()->findAll('contest_id=' . $last_contest);

        foreach ($works as $work) {
            echo $work->user_id."\n";
            Yii::app()->email->send((int)$work->user_id, 'contest_continue', array('user' => $work->author, 'work' => $work), $this);
        }
    }

    public function actionContestPets()
    {
        $users = array();

        Yii::import('site.frontend.modules.community.models.*');
        $works = CommunityContestWork::model()->with('content')->findAll(array(
            'condition' => 't.contest_id = 1 AND content.removed = 0',
        ));

        foreach ($works as $work) {
            if (! isset($users[$work->content->author->id])) {
                echo $work->id . "\n";
                Yii::app()->email->send((int)$work->content->author->id, 'contest_pets', array('work' => $work, 'photo' => $work->content->gallery->items[0]->photo, 'author' => $work->content->author), $this);
                $users[] = $work->content->author->id;
            }
        }
    }

    public function actionVacancyTest()
    {
        $a = array(
            'pavel@happy-giraffe.ru' => 'Павел',
            'nikita@happy-giraffe.ru' => 'Никита',
            'tantalid@mail.ru' => 'Андрей',
            'andrey@happy-giraffe.ru' => 'Андрей',
        );

        foreach ($a as $email => $firstName) {
            $subject = $firstName . ', мы ищем Frontend-разработчика!';
            $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'vacancyInvite2.php', compact('firstName'), true);
            ElasticEmail::send($email, $subject, $html, 'noreply@happy-giraffe.ru', 'Весёлый Жираф');
        }
    }

    public function actionVacancy()
    {
        $criteria = new EMongoCriteria();
        $criteria->limit(1000);
        $criteria->parsed('!=', false);
        //$criteria->send('==', false);
        $models = HhResume::model()->findAll($criteria);
        $a = count($models);
        var_dump($a);
        die;
        foreach ($models as $m) {
            if (isset($m->contacts['Эл. почта'])) {
                $email = $m->contacts['Эл. почта'];
                $firstName = $m->firstName;
                $subject = $firstName . ', мы ищем Frontend-разработчика!';
                $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'vacancyInvite2.php', compact('firstName'), true);
                if (ElasticEmail::send($email, $subject, $html, 'noreply@happy-giraffe.ru', 'Весёлый Жираф')) {
                    $m->send = true;
                    $m->save();
                }
            }
        }
    }

    public function actionContestKidsMailRuTest()
    {
        $testList = array(
            'tantalid@gmail.com',
            'tantalid@mail.ru',
            'tantalid@rambler.ru',
            'tantalid@yandex.ru',
            'nikita@happy-giraffe.ru',
        );

        foreach ($testList as $mail) {
            $subject = 'Андрей, принимай участие в конкурсе «Поделись улыбкою своей»!';
            $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'contest_12.php', array(), true);
            Yii::app()->email->sendEmail($mail, $subject, $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
        }
    }

    public function actionContestPregnancyMailRuTest()
    {
        $testList = array(
            'tantalid@gmail.com',
            'tantalid@mail.ru',
            'tantalid@rambler.ru',
            'tantalid@yandex.ru',
            'nikita@happy-giraffe.ru',
        );

        foreach ($testList as $mail) {
            $subject = 'Андрей, принимай участие в конкурсе «Как я рассказала своему мужу о беременности»!';
            $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'contest_12.php', array(), true);
            Yii::app()->email->sendEmail($mail, $subject, $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
        }
    }

    public function actionContestKidsMailRu()
    {
        $offset = 0;
        $i = 0;
        do {
            $criteria = new EMongoCriteria();
            $criteria->list = (string) MailruUser::LIST_CHILD;
            $criteria->limit(1000);
            $criteria->offset($offset);
            $models = MailruUser::model()->findAll($criteria);
            foreach ($models as $model) {
                $subject = $model->firstName . ', принимай участие в конкурсе «Моя любимая игрушка»!';
                $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'contest_13.php', compact('model'), true);
                Yii::app()->email->sendEmail($model->email, $subject, $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
                $i++;
            }
            $offset += 1000;
        } while (! empty($models));
        echo $i . ' sent';
    }

    public function actionContestPregnancyMailRu()
    {
        $offset = 0;
        $i = 0;
        do {
            $criteria = new EMongoCriteria();
            $criteria->list = (string) MailruUser::LIST_CHILD;
            $criteria->limit(1000);
            $criteria->offset($offset);
            $models = MailruUser::model()->findAll($criteria);
            foreach ($models as $model) {
                $subject = $model->firstName . ', принимай участие в конкурсе «Как я рассказала своему мужу о беременности»!';
                $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'contest_birth2.php', compact('model'), true);
                Yii::app()->email->sendEmail($model->email, $subject, $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
                $i++;
            }
            $offset += 1000;
        } while (! empty($models));
        echo $i . ' sent';
    }

    public function actionHeinzMailRu()
    {
        $offset = 0;
        $i = 0;
        do {
            $criteria = new EMongoCriteria();
            $criteria->list = (string) MailruUser::LIST_PREGNANCY;
            $criteria->limit(1000);
            $criteria->offset($offset);
            $models = MailruUser::model()->findAll($criteria);
            foreach ($models as $model) {
                $subject = $model->firstName . ', принимай участие в конкурсе «Лучший вопрос о качестве и безопасности детского питания»!';
                $html = $this->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . 'heinz.php', compact('model'), true);
                Yii::app()->email->sendEmail($model->email, $subject, $html, 'noreply@happy-giraffe.ru', 'Веселый Жираф');
                $i++;
            }
            $offset += 1000;
        } while (! empty($models));
        echo $i . ' sent';
    }
}