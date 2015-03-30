<?php
namespace site\frontend\modules\analytics\commands;
use site\frontend\modules\analytics\components\MigrateManager;
use site\frontend\modules\analytics\components\VisitsManager;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 26/01/15
 */

class ViewsCommand extends \CConsoleCommand
{
//    public function actionFlushVisits()
//    {
//        \Yii::app()->getModule('analytics')->visitsManager->flushBuffer();
//    }
//
//    public function actionDebug()
//    {
//        $b = \Yii::app()->getModule('analytics')->visitsManager->showBuffer();
//        echo count($b);
//    }

    public function actionCheat($url, $perDay)
    {
        $day = 60*24;
        $val = $perDay / $day;
        $int = floor($val);
        $float = $val - $int;
        $rnd = mt_rand() / mt_getrandmax();
        $res = $int + (($rnd < $float) ? 1 : 0);
        echo "$float\n$rnd\n$res\n";
        $model = PageView::getModel($url);
        $model->result += $res;
        $model->save();
    }


    public function actionMigrate()
    {
        $manager = new MigrateManager();
        $manager->run();
    }

    public function actionTest()
    {
        $model = PageView::getModel("http://www.happy-giraffe.ru/community/32/forum/post/249149/");

        var_dump($model);

        $model->incVisits(1);
    }
} 