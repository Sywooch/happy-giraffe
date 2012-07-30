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
     *
     * Раз в 5 минут
     */
    public function actionIndex()
    {
        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.common.models.mongo.*');
        ScoreInput::CheckOnClose();
    }
}

