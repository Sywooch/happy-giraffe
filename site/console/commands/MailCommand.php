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
        ob_start();
        $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews').'.php', array('models'=>$articles));
        $contents = ob_get_clean();
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
}

