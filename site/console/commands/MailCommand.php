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
        if (Yii::app()->createUrl('site/index') != './' && Yii::app()->createUrl('site/index') != '/') {
            echo Yii::app()->createUrl('site/index') . ' - url failed';
            return false;
        }

        $articles = Favourites::model()->getWeekPosts();
        if (count($articles) < 6)
            Yii::app()->end();
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);

        Yii::app()->email->sendCampaign($contents, HEmailSender::LIST_OUR_USERS);
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
        Yii::import('site.seo.modules.mailru.models.*');

        Yii::app()->email->updateMailruUsers();
    }

    public function actionUsers()
    {
        Yii::app()->email->updateUserList();
    }

    public function actionDeleteUsers()
    {
        Yii::app()->mc->deleteRegisteredFromContestList();
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

    public function actionImportUsers()
    {
        HEmailSender::importUsers();
    }

    public function actionExport()
    {
        $emails = Yii::app()->db_seo->createCommand()
            ->select('email')
            ->from('mailru__users')
            ->where('id >= 534973')
            ->limit(100)
            ->queryColumn();
        foreach($emails as $email)
            echo $email."\n";
    }



    // эта функция отправляет команду в сокет, и возвращает ответ от сервера
    function sWrite( $socket, $data, $echo = true ){
        // отображаем отправляемую команду, если это требуется
        if( $echo ) echo $data;
        // отправляем команду в сокет
        fputs( $socket, $data );
        // получаем первый байт ответа от сервера
        $answer = fread( $socket, 1 );
        // узнаем информацию о состоянии потока
        $remains = socket_get_status( $socket );
        // и получаем оставшиеся байты ответа от сервера
        if( $remains --> 0 ) $answer .= fread( $socket, $remains['unread_bytes'] );
        // функция возвращает ответ от сервера на переданную команду
        return $answer;
    }

    public function actionCheckMail(){
        // адрес электропочты, который надо проверить
        $email = "piks.75@mail.ru";
        // получаем данные об MX-записи домена, указанного в email
        $mx = dns_get_record( end( explode( "@", $email ) ), DNS_MX );
        $mx = $mx[0]['target'];
        // открываем сокет и создаем поток
        $socket = fsockopen( $mx, 25, $errno, $errstr, 10 );
        if( !$socket ){
            echo "$errstr ($errno)\n";
        }else{
            // отправляем пустую строку, чтобы получить приветствие сервера
            echo $this->sWrite( $socket, "" );
            // представляемся сами
            echo $this->sWrite( $socket, "EHLO example.com\r\n" );
            echo $this->sWrite( $socket, "MAIL FROM: dummy@example.com\r\n" );
            // запрашиваем разрешение на отправку письма адресату
            $response = $this->sWrite( $socket, "RCPT TO: $email\r\n" );
            echo $response;
            // закрываем соединение
            echo $this->sWrite( $socket, "QUIT\r\n" );
            fclose( $socket );
            // ниже идет простейшая обработка полученного ответа
            echo "\nCheck report:\n";
            if( substr_count( $response, "550" ) > 0 ) echo "Required email address does not exist.\n\n";
            else if( substr_count( $response, "250" ) > 0 ) if( substr_count( $response, "OK" ) > 0 ) echo "  Required email address exists.\n\n";
            else echo "  Email address accepted but it looks like the server is working as a relay host.\n\n";
            else echo "  Required email address existence was not recovered. Last response:\n  ---\n$response  ---\n\n";
        }

    }
}