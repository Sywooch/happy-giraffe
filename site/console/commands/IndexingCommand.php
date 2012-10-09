<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class IndexingCommand extends CConsoleCommand
{

    public function actionAddUrls()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');
        Yii::import('site.frontend.components.CutBehavior');

        $urlCollector = new UrlCollector;
        $urlCollector->collectUrls();
    }

    public function actionDropUrls()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');
        Yii::import('site.frontend.components.CutBehavior');

        echo "start\n";
        $urlCollector = new UrlCollector;
        $urlCollector->removeUrls();
    }

    public function actionRefresh()
    {
        //remove log file
        $file = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'indexing_log.txt';
        if (file_exists($file))
            unlink($file);

        Yii::app()->db_seo->createCommand('update proxies set active = 0')->execute();
        Yii::app()->db_seo->createCommand('update indexing__urls set active = 0')->execute();
    }

    public function actionRestart()
    {
        Yii::app()->db_seo->createCommand('update proxies set active = 0')->execute();
        Yii::app()->db_seo->createCommand('update indexing__urls set active = 0 where active = 1')->execute();
    }

    public function actionParse()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');
        Config::setAttribute('stop_threads', 0);

        $parser = new IndexParserThread();
        $parser->start();
    }

    public function actionAddUp()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');

        $model = new IndexingUp();
        $model->date = date("Y-m-d");
        echo $model->save();
    }
}

