<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */
class UserScoresCommand extends CConsoleCommand
{

    public function beforeAction()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        return true;
    }

    /**
     * Нужно для объдинения в группы оповещений о набранных баллах. Просматриваем все открытые записи о начислении
     * баллов и если время закрывать, то закрываем. После закрытия оно отобразиться в статистике
     */
    public function actionIndex()
    {
        while (1) {
            Yii::import('site.frontend.modules.scores.models.*');
            ScoreInput::CheckOnClose();
            sleep(60);
        }
    }
}

