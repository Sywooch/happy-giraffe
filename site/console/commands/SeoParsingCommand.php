<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.common.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.seo.modules.traffic.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.frontend.helpers.*');

class SeoParsingCommand extends CConsoleCommand
{
    public function actionWordstat($mode = 0)
    {
        $parser = new WordstatParser();
        $parser->start($mode);
    }

    public function actionLi($site)
    {
        Yii::import('site.seo.modules.competitors.components.*');
        $last_parsed = SeoUserAttributes::getAttribute('last_li_parsed_'.date("Y-m") , 1);
        if (empty($site)) {
            $parser = new LiParser;

            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > '.$last_parsed);
            else
                $sites = Site::model()->findAll();

            foreach ($sites as $site) {
                $parser->start($site->id, 2012, 01, 01);

                SeoUserAttributes::setAttribute('last_li_parsed_'.date("Y-m") , $site->id, 1);
            }
        } else {
            $parser = new LiParser;
            $parser->start($site, 2012, 01, 01);
        }
    }

    public function actionLiKeywords($site){
        Yii::import('site.seo.modules.competitors.components.*');

        $last_parsed = SeoUserAttributes::getAttribute('last_li_parsed_'.date("Y-m-d") , 1);
        $parser = new LiKeywordsParser;

        if (empty($site)) {
            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > '.$last_parsed);
            else
                $sites = Site::model()->findAll();

            foreach ($sites as $site) {
                $parser->start($site->id);
                SeoUserAttributes::setAttribute('last_li_parsed_'.date("Y-m-d"), $site->id, 1);
            }
        } else {
            $parser = new LiKeywordsParser(false);
            $parser->start($site);
        }
    }

    public function actionParseSites($page){
        Yii::import('site.seo.modules.competitors.components.*');

        $parser = new LiSitesParser;
        $parser->start($page);
    }

    public function actionParseSitesTest(){
        Yii::import('site.seo.modules.competitors.components.*');

        $parser = new LiSitesParser(true, $debug_mode = true);
        $parser->changeRuProxy();
        //$parser->start();
    }
}

