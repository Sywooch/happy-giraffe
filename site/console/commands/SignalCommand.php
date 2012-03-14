<?php
/**
 * User: alexk984
 * Date: 10.03.12
 *
 * Если модератор за 5 имнут не выполнил задание, отменяем его.
 */
class SignalCommand extends CConsoleCommand
{
    public function beforeAction(){
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.UserSignal');

        return true;
    }

    public function actionIndex()
    {
        Yii::import('site.frontend.modules.signal.models.*');
        UserSignalResponse::CheckLate();
    }
}
