<?php
/**
 * Author: alexk984
 * Date: 05.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class LinkingCommand extends CConsoleCommand
{
    public function actionPrepareParsing()
    {
        Yii::app()->db_seo->createCommand()->delete('yandex_search_results');
        Yii::app()->db_seo->createCommand()->delete('yandex_search_keywords');

        $keywords = Yii::app()->db_seo->createCommand()
            ->selectDistinct('keyword_id')
            ->from('pages_search_phrases')
            ->where('last_yandex_position < 1000 OR google_traffic > 0')
            ->queryColumn();

        foreach ($keywords as $keyword) {
            $model = new YandexSearchKeyword;
            $model->keyword_id = $keyword;
            $model->save();
        }
    }

    public function actionAddPhrases()
    {
        $keywords = Yii::app()->db_seo->createCommand()
            ->selectDistinct('keyword_id')
            ->from('pages_search_phrases')
            ->queryColumn();

        foreach ($keywords as $keyword) {
            $keyword_model = Keyword::model()->findByPk($keyword);
            if ($keyword_model === null) {
                PagesSearchPhrase::model()->deleteAll('keyword_id=' . $keyword);
                echo 'deleted' . "\n";
            } elseif (YandexSearchKeyword::model()->findByPk($keyword) === null) {
                $model = new YandexSearchKeyword;
                $model->keyword_id = $keyword;
                $model->save();
            }
        }
    }

    public function actionParse()
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new SearchResultsParser();
        $parser->start();
    }

    public function actionServiceLinks()
    {
        $urls = array(
            //'http://www.happy-giraffe.ru/test/pregnancy/',
            'http://www.happy-giraffe.ru/babySex/',
            'http://www.happy-giraffe.ru/babySex/china/',
            'http://www.happy-giraffe.ru/babySex/japan/',
            'http://www.happy-giraffe.ru/babySex/bloodRefresh/',
            'http://www.happy-giraffe.ru/babySex/blood/',
            'http://www.happy-giraffe.ru/babySex/ovulation/',
        );

        $articles = $this->getArticles('определение пола');
        echo count($articles) . "\n";

        foreach ($urls as $url) {
            echo $url . "\n";
            $page = Page::model()->findByAttributes(array('url' => $url));
            foreach ($page->keywordGroup->keywords as $keyword) {
                $phrase = PagesSearchPhrase::model()->findByAttributes(array(
                    'page_id' => $page->id,
                    'keyword_id' => $keyword->id,
                ));
                if ($phrase === null) {
                    $phrase = new PagesSearchPhrase;
                    $phrase->keyword_id = $keyword->id;
                    $phrase->page_id = $page->id;
                    $phrase->save();
                }

                $exist = true;
                while ($exist) {
                    $from_article = $this->getRandomArticle($articles);
                    $from_page = Page::model()->getOrCreate('http://www.happy-giraffe.ru' . trim($from_article->url, '.'));
                    if ($from_page->outputLinksCount > 3)
                        $exist = true;
                    else
                        $exist = InnerLink::model()->exists('page_id = ' . $from_page->id . ' and page_to_id=' . $page->id);
                }

                $link = new InnerLink();
                $link->page_id = $from_page->id;
                $link->page_to_id = $phrase->page_id;
                $link->phrase_id = $phrase->id;
                $link->keyword_id = $keyword->id;
                $link->save();

                echo $from_page->url . "\n";
            }
        }
    }

    public function actionHoroscopeLinks()
    {
        $url = 'http://www.happy-giraffe.ru/horoscope/';
        $page = Page::model()->findByAttributes(array('url' => $url));

        $keyword = Keyword::GetKeyword('гороскоп на сегодня');
        $phrase = PagesSearchPhrase::model()->findByAttributes(array(
            'page_id' => $page->id,
            'keyword_id' => $keyword->id,
        ));
        if ($phrase === null) {
            $phrase = new PagesSearchPhrase;
            $phrase->keyword_id = $keyword->id;
            $phrase->page_id = $page->id;
            $phrase->save();
        }

        $articles = $this->getArticles('гороскоп');
        echo count($articles) . "\n";

        foreach ($articles as $article) {
            $from_page = Page::model()->getOrCreate('http://www.happy-giraffe.ru' . trim($article->url, '.'));
            echo $from_page->url."\n";
            $exist = InnerLink::model()->exists('page_id = ' . $from_page->id . ' and page_to_id=' . $page->id);

            if (!$exist){
                //ссылки нет можно ставить
                echo "Link not exist can be placed\n";
                $link = new InnerLink();
                $link->page_id = $from_page->id;
                $link->page_to_id = $phrase->page_id;
                $link->phrase_id = $phrase->id;
                $link->keyword_id = $keyword->id;
                $link->save();
            }else
                echo "Link already exist\n";
        }
    }

    private function getRandomArticle($articles)
    {
        $rand = rand(0, count($articles) - 1);
        $result = $articles[$rand];
        unset($articles[$rand]);

        return $result;
    }

    private function getArticles($phrase)
    {
        $result = Yii::app()->search
            ->select('*')
            ->from('communityText')
            ->where(' ' . $phrase . ' ')
            ->limit(0, 2000)
            ->searchRaw();
        $ids = array();
        foreach ($result['matches'] as $key => $m)
            $ids [] = $key;

        if (empty($ids))
            throw new Exception('not found articles');

        $criteria = new CDbCriteria;
        $criteria->compare('id', $ids);
        return CommunityContent::model()->findAll($criteria);
    }

    public function actionSync()
    {
        Yii::import('site.common.models.mongo.*');

        //InnerLinksBlock::model()->Sync($this);
    }

    public function actionSyncRemoved()
    {
        Yii::import('site.common.models.mongo.*');
        InnerLinksBlock::model()->RemoveDeleted();
    }

    public function actionCalcLinksCount()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = PagesSearchPhrase::model()->findAll($criteria);

            foreach ($models as $model) {
                $model->calculateLinksCount();
            }

            $criteria->offset += 100;

            echo $criteria->offset . "\n";
        }
    }

    public function actionCheckBadLinks()
    {
        $links = InnerLink::model()->findAll('page_id=page_to_id');
        echo count($links) . "\n";
        foreach ($links as $link)
            $link->delete();
    }

    public function actionLinks(){
        Yii::import('site.seo.modules.promotion.components.*');
        $c = new CLinking();
        $c->start();
    }
}