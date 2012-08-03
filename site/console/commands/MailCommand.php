<?php

class MailCommand extends CConsoleCommand
{
    public function actionIndex(){
        ob_start();
        $this->beginWidget('site.common.widgets.mail.WeeklyArticlesWidget');
        $this->endWidget();

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

