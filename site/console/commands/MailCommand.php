<?php

class MailCommand extends CConsoleCommand
{
    public function actionIndex(){

    }

    public function actionWeeklyNews()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.common.models.mongo.*');

        $articles = Favourites::model()->getWeekPosts();
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews').'.php', array('models'=>$articles), true);
        $vals = Yii::app()->mc->sendWeeklyNews('самое свежее на этой неделе', $contents);

        if (Yii::app()->mc->api->errorCode){
            echo "Batch Subscribe failed!\n";
            echo "code:".Yii::app()->mc->api->errorCode."\n";
            echo "msg :".Yii::app()->mc->api->errorMessage."\n";
        } else {
            echo "added:   ".$vals['add_count']."\n";
            echo "updated: ".$vals['update_count']."\n";
            echo "errors:  ".$vals['error_count']."\n";
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

        $user = User::model()->findByPk(10);
        $token = UserToken::model()->generate($user->id, 86400);
        $unread = Im::model($user->id)->getUnreadMessagesCount();
        if ($unread > 0){
            $dialogUsers = Im::model($user->id)->getUsersWithNewMessages();
            $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.newMessages').'.php', compact('dialogUsers', 'unread', 'user', 'token'), true);
            Yii::app()->mandrill->send($user, 'newMessages', array('messages' => $contents, 'token' => $token));
        }
    }

    public function actionUsers(){
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');

        Yii::app()->mc->updateUsers();
    }

    public function actionUsersTest(){
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');

        Yii::app()->mc->updateUsersTest();
    }

    public function actionDeleteUsers()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');

        Yii::app()->mc->deleteUsers();
    }
}

