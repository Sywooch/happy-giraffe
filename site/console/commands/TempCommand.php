<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/26/13
 * Time: 7:43 PM
 * To change this template use File | Settings | File Templates.
 */

class TempCommand extends CConsoleCommand
{
    public function actionCheatPampers()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.PageView');
        while (true) {
            PageView::model()->cheat('/community/10/forum/post/101319/', 0, 1);
            sleep(60);
        }
    }

    public function actionBabies()
    {
        $dp = new CActiveDataProvider('Baby');
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $baby)
            $baby->save(false);
    }

    public function actionClearblue($date1, $date2)
    {
        $views = GApi::model()->pageViews('/test/pregnancy/', $date1, $date2);
        $uniqueVisitors = GApi::model()->uniquePageViews('/test/pregnancy/', $date1, $date2);
        echo 'Views: ' . $views . "\n";
        echo 'Unique visitors: ' . $uniqueVisitors . "\n";
    }

    public function actionAddProxy()
    {
        Yii::import('site.seo.models.mongo.*');

        $a = array (
            '46.165.200.102:701',
            '46.165.200.104:701',
            '95.211.156.222:701',
            '95.211.189.193:701',
            '95.211.189.194:701',
            '95.211.189.197:701',
            '46.165.200.108:701',
            '46.165.200.117:701',
            '46.165.200.118:701',
            '95.211.159.77:701',
            '5.79.80.216:701',
            '95.211.199.9:701',
            '5.79.86.212:701',
            '5.79.86.213:701',
            '5.79.86.205:701',
            '5.79.86.206:701',
            '95.211.231.133:701',
            '95.211.195.161:701',
        );

        foreach ($a as $proxy)
            ProxyMongo::model()->addNewProxy($proxy);
    }
}