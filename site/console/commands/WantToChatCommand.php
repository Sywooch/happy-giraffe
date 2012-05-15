<?php
/**
 * Author: choo
 * Date: 15.05.2012
 */
class WantToChatCommand extends CConsoleCommand
{
    public function actionClear()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.WantToChat');

        $criteria = new EMongoCriteria;
        $criteria->created('<', time() - WantToChat::CHAT_COOLDOWN);

        WantToChat::model()->deleteAll($criteria);
    }
}
