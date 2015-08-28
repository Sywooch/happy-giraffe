<?php
namespace site\frontend\modules\analytics\commands;
use site\frontend\modules\analytics\components\MigrateManager;
use site\frontend\modules\analytics\components\VisitsManager;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\consultation\models\ConsultationQuestion;
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

    public function actionCheat($url, $perDay, $till = null)
    {
        if (date('Y-m-d') > $till) {
            return;
        }

        $day = 60*24;
        $val = $perDay / $day;
        $int = floor($val);
        $float = $val - $int;
        $rnd = mt_rand() / mt_getrandmax();
        $res = $int + (($rnd < $float) ? 1 : 0);
        $model = PageView::getModel($url);
        $model->incVisits($res);

        echo $res . "\n";
    }

    public function actionOneTime($url, $count)
    {
        $model = PageView::getModel($url);
        $model->incVisits((int) $count);
    }

    public function actionMigrate()
    {
        $manager = new MigrateManager();
        $manager->run();
    }

    public function actionTest()
    {
        $model = PageView::getModel("http://www.happy-giraffe.ru/community/7/forum/post/268736/");

        //var_dump($model);

        $model->incVisits(2198);
    }

    public function actionConsultation()
    {
        $models = ConsultationQuestion::model()->findAll();
        $s = 0;
        foreach ($models as $m) {
            $model = PageView::getModel($m->url);
            $s += $model->getCounter();
        }
        echo count($models) . "\n";
        echo "$s\n";
    }
} 
