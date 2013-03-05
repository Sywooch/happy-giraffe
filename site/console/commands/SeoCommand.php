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
        TrafficStatisctic::model()->parse();
    }

    public function actionLi($site)
    {
        Yii::import('site.seo.modules.competitors.components.*');
        $last_parsed = SeoUserAttributes::getAttribute('last_li_parsed_' . date("Y-m"), 1);
        if (empty($site)) {
            $parser = new LiParser;

            if (!empty($last_parsed))
                $sites = Site::model()->findAll('id > ' . $last_parsed);
            else
                $sites = Site::model()->findAll();

            foreach ($sites as $site) {
                $parser->start($site->id, 2012, 12, 12);

                SeoUserAttributes::setAttribute('last_li_parsed_' . date("Y-m"), $site->id, 1);
            }
        } else {
            $parser = new LiParser;
            $parser->start($site, 2012, 12, 12);
        }
    }

    public function actionCopyWordstat()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 10000;
        $criteria->order = 'keyword_id ASC';

        $models = array(0);
        $last_id = 0;
        $i = 0;
        while (!empty($models)) {
            $criteria->condition = 'keyword_id > ' . $last_id;
            $models = YandexPopularity::model()->findAll($criteria);

            foreach ($models as $model) {

                Yii::app()->db_keywords->createCommand()->update('keywords',
                    array('wordstat' => $model->value), 'id = ' . $model->keyword_id);
                $last_id = $model->keyword_id;
            }
            $i++;
            if ($i % 10 == 0)
                echo $last_id . "\n";
        }
    }

    public function actionCleanTable()
    {
        $table = 'queries';

        $ids = Yii::app()->db_seo->createCommand()
                    ->select('keyword_id')
                    ->from($table)
                    ->queryColumn();

        echo count($ids)."\n";
        foreach($ids as $id){
            $keyword = Keyword::model()->findByPk($id);
            if ($keyword === null)
                echo $id."\n";
        }
    }
}

