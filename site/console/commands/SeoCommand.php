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
    public function actionParseSeVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionParseDataForSe()
    {
        $metrica = new YandexMetrica();
        $metrica->parseDataForAllSE();
    }

    public function actionConvertVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionConvertPrevVisits($week)
    {
        $metrica = new YandexMetrica($week);
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionParseMonthTraffic()
    {
        $metrica = new YandexMetrica(1);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();

        $metrica = new YandexMetrica(2);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();

        $metrica = new YandexMetrica(3);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionWeekTraffic($week)
    {
        $metrica = new YandexMetrica($week);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionStopThreads()
    {
        Config::setAttribute('stop_threads', 1);
    }

    public function actionWordstat($mode = 0)
    {
        $parser = new WordstatParser();
        $parser->start($mode);
    }

    public function actionCalculateMain()
    {
        $metrica = new YandexMetrica();
        $metrica->calculateMain();
    }

    public function actionAddSeVisitsToWordStat()
    {
        $se = PagesSearchPhrase::model()->findAll();

        foreach ($se as $phrase) {
            $yandex = YandexPopularity::model()->find('keyword_id =' . $phrase->keyword_id);
            if ($yandex !== null && $yandex->parsed == 1)
                continue;

            $model = ParsingKeyword::model()->find('keyword_id =' . $phrase->keyword_id);
            if ($model === null) {
                $parse = new ParsingKeyword();
                $parse->keyword_id = $phrase->keyword_id;
                $parse->depth = 1;
                $parse->priority = 5;
                if (!$parse->save()) {
                    var_dump($parse->getErrors());
                    Yii::app()->end();
                }
            } else {
                $model->priority = 5;
                $model->save();
            }
        }
    }

    public function actionImportVisits()
    {
        Yii::import('site.seo.modules.competitors.models.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;

        $i = 0;
        $count = SitesKeywordsVisit2::model()->count();
        $models = array(0);
        while (!empty($models)) {
            $models = SitesKeywordsVisit2::model()->findAll($criteria);

            foreach ($models as $model) {
                $keyword_id = Keyword::GetKeyword($model->keyword)->id;
                $model2 = SiteKeywordVisit::model()->findByAttributes(array(
                    'keyword_id' => $keyword_id,
                    'site_id' => $model->site_id,
                    'year' => $model->year,
                ));
                if ($model2 === null) {
                    $model2 = new SiteKeywordVisit();
                    $model2->keyword_id = $keyword_id;
                }
                $model2->attributes = $model->attributes;
                $model2->save();
                $i++;
            }

            $criteria->offset += 1000;

            echo round(100 * $i / $count, 2) . "%\n";
        }
    }

    public function actionProxy()
    {
        ProxyRefresher::execute();
    }

    public function actionAddToParsing()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;

        $i = 0;
        $visits = array(1);
        while (!empty($visits)) {
            $criteria->offset = 1000 * $i;

            $visits = SiteKeywordVisit::model()->findAll($criteria);
            foreach ($visits as $visit) {
                $yandex = YandexPopularity::model()->find('keyword_id =' . $visit->keyword_id);
                if ($yandex !== null && $yandex->parsed == 1)
                    continue;

                $model = ParsingKeyword::model()->find('keyword_id =' . $visit->keyword_id);
                if ($model === null) {
                    $parse = new ParsingKeyword();
                    $parse->keyword_id = $visit->keyword_id;
                    $parse->priority = 4;
                    if (!$parse->save()) {
                        var_dump($parse->getErrors());
                        Yii::app()->end();
                    }
                } else {
                    $model->priority = 4;
                    $model->save();
                }
            }
            $i++;
        }
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

    public function actionMailruForumParser()
    {
        Yii::import('site.seo.modules.mailru.components.*');

        $parser = new MailRuForumParser;
        $parser->start();
    }

    public function actionMailruForumThemeParser()
    {
        Yii::import('site.seo.modules.mailru.components.*');

        $parser = new MailRuForumThemeParser;
        $parser->start();
    }

    public function actionMailruCommunityUsersParser()
    {
        Yii::import('site.seo.modules.mailru.components.*');

        $parser = new MailRuCommunityUsersParser;
        $parser->start();
    }

    public function actionDetiUsersParser()
    {
        Yii::import('site.seo.modules.mailru.components.*');

        $parser = new DetiUserSearchParser();
        $parser->start();
    }

    public function actionDetiFriendsParser()
    {
        Yii::import('site.seo.modules.mailru.components.*');

        $parser = new DetiFriendsParser();
        $parser->start();
    }

    public function actionMailruCollect()
    {
        Yii::import('site.seo.modules.mailru.components.*');

        MailRuForumParser::collectContests();
    }

    public function actionMailruCount()
    {
        Yii::import('site.seo.modules.mailru.components.*');

        $models = Yii::app()->db_seo->createCommand()
            ->selectDistinct('parent_id')
            ->from('mailru__babies')
            ->queryColumn();
        echo count($models) . " parents have children \n";

        echo  Yii::app()->db_seo->createCommand()
            ->select('count(id)')
            ->from('mailru__babies')
            ->queryScalar() . " babies count\n";
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
        Yii::import('site.frontend.components.*');
        $date = date("Y-m-d", strtotime('-3 month'));

        $sections = TrafficSection::model()->findAll();

        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $ga->setProfile('ga:53688414');

        while (strtotime($date) < time()) {
            echo $date . "\n";

            foreach ($sections as $section) {
                $traffic = TrafficStatisctic::model()->findByAttributes(array('date' => $date, 'section_id' => $section->id));
                if ($traffic === null || strtotime($date) > strtotime('-2 days')) {
                    if (!empty($section->url))
                        $value = GApi::getUrlOrganicSearches($ga, $date, $date, '/' . $section->url . '/');
                    else
                        $value = GApi::getUrlOrganicSearches($ga, $date, $date, '/');

                    if ($value == -1)
                        Yii::app()->end();

                    echo $section->url . ' - ' . $value . "\n";
                    if ($value >= 0) {
                        if ($traffic === null) {
                            $traffic = new TrafficStatisctic();
                            $traffic->section_id = $section->id;
                            $traffic->date = $date;
                        }
                        $traffic->value = $value;
                        $traffic->save();
                    }
                }
            }

            $date = date("Y-m-d", strtotime('+1 day', strtotime($date)));
        }
    }

    public function actionLi($site){
        Yii::import('site.seo.modules.competitors.components.*');
        if (empty($site)){
            $sites = Site::model()->findAll('id > 57');
            foreach($sites as $site){
                $parser = new LiParser;
                $parser->start($site->id, 2012, 11, 12);
            }
        }else{
            $parser = new LiParser;
            $parser->start($site, 2012, 11, 12);
        }
    }
}

