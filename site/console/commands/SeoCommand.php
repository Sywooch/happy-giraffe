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

class SeoCommand extends CConsoleCommand
{
    public function actionStopThreads()
    {
        Config::setAttribute('stop_threads', 1);
    }

    public function actionWordstat($thread_id = 0)
    {
        $parser = new WordstatFilter($thread_id);
        $parser->start();
    }

    public function actionProxy()
    {
        ProxyRefresher::execute();
    }

    public function actionDeletePageDuplicates()
    {
        Yii::import('site.common.behaviors.*');
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->findAll($criteria);

            foreach ($models as $model) {
                $criteria2 = new CDbCriteria;
                $criteria2->compare('url', $model->url);
                $criteria2->order = 'id asc';
                $samePages = Page::model()->findAll($criteria2);
                if (count($samePages) > 1) {
                    echo $model->url . ' - ' . count($samePages) . "\n";

                    $first = true;
                    foreach ($samePages as $samePage) {
                        echo $samePage->outputLinksCount . ' : ' . $samePage->inputLinksCount
                            . ' : ' . $samePage->taskCount . ' : ' . $samePage->phrasesCount
                            . ' : ' . $samePage->keywordGroup->taskCount
                            . ' : ' . count($samePage->keywordGroup->keywords) . "\n";

//                        if ($samePage->outputLinksCount == 0
//                            && $samePage->inputLinksCount == 0
//                            && $samePage->taskCount == 0
//                            && $samePage->phrasesCount == 0
//                            && empty($samePage->keywordGroup->keywords)
//                            && $samePage->keywordGroup->taskCount == 0
//                        ) {
                        if (!$first)
                            $samePage->delete();
//                        }

                        $first = false;
                    }
                }
            }

            echo $criteria->offset . "\n";
            $criteria->offset += 900;
        }
    }

    public function actionCheckEntities()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->findAll($criteria);

            foreach ($models as $model) {
                list($entity, $entity_id) = Page::ParseUrl($model->url);

                if (!empty($entity) && !empty($entity_id) && $entity != $model->entity) {
                    echo $entity . "\n";
                    $model->entity = $entity;
                    $model->entity_id = $entity_id;
                    $model->save();
                }
            }

            $criteria->offset += 100;
        }
    }

    public function actionPopular()
    {
        $criteria = new EMongoCriteria();
        $criteria->limit(100);

        $result = array();
        $models = array(0);
        while (!empty($models)) {
            $models = PageView::model()->findAll($criteria);

            foreach ($models as $model)
                if (strpos($model->_id, '/cook/recipe/') !== false
                    || strpos($model->_id, '/cook/multivarka/') !== false
                )
                    $result [] = array('path' => $model->_id, 'views' => $model->views);

            $criteria->setOffset($criteria->getOffset() + 100);
        }

        //sort array
        usort($result, array($this, 'cmp'));
        $result = array_slice($result, 0, 100);
        foreach ($result as $model)
            echo 'http://www.happy-giraffe.ru' . $model['path'] . "\n";
    }

    function cmp($a, $b)
    {
        if ($a['views'] == $b['views'])
            return 0;
        return ($a['views'] > $b['views']) ? -1 : 1;
    }

    public function actionParseTraffic()
    {
        TrafficStatisctic::model()->parse();
    }

    public function actionParseSeTraffic()
    {
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.extensions.*');
        PageStatistics::model()->parseSe();
    }

    public function actionExport()
    {
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.extensions.*');
        PageStatistics::model()->export();
    }

    public function actionTest()
    {
        $rubrics = LiSiteRubric::model()->findAll();

        $li_sites = LiSite::model()->findAll('type=' . LiSite::TYPE_LI . ' AND public=1 AND rubric_id IS NULL');
        $i = 1;
        foreach ($li_sites as $li_site) {
            $html = file_get_contents('http://www.liveinternet.ru/stat/' . $li_site->url . '/');
            $document = phpQuery::newDocument($html);
            $link = $document->find('div:eq(3) a:eq(2)');
            $cat = trim(str_replace('/rating/ru/', '', pq($link)->attr('href')), '/');
            foreach ($rubrics as $rubric)
                if ($rubric->url == $cat) {
                    $li_site->rubric_id = $rubric->id;
                    $li_site->save();
                }
            if (empty($cat)){
                $li_site->public = 0;
                $li_site->save();
            }

            $i++;
            echo $i."\n";
        }
    }
}

