<?php
Yii::import('site.seo.models.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

/**
 * Class LinkingCommand
 *
 * Внутренняя перелинковка
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class LinkingCommand extends CConsoleCommand
{
    /**
     * Подготовка парсинга страниц нашего сайта в яндексе по ключевым словам
     * нужно для поиска похожих страниц, чтобы использовать их в качестве доноров ссылок
     */
    public function actionPrepareParsing()
    {
        Yii::app()->db_seo->createCommand()->delete('yandex_search_results');
        Yii::app()->db_seo->createCommand()->delete('yandex_search_keywords');

        $keywords = Yii::app()->db_seo->createCommand()
            ->selectDistinct('keyword_id')
            ->from('pages_search_phrases')
            ->queryColumn();

        foreach ($keywords as $keyword) {
            $model = new YandexSearchKeyword;
            $model->keyword_id = $keyword;
            $model->save();
        }
    }

    /**
     * Парсинг страниц нашего сайта в яндексе по ключевым словам, нужно для поиска
     * похожих страниц, чтобы использовать их в качестве доноров ссылок
     */
    public function actionParse()
    {
        $parser = new SearchResultsParser();
        $parser->start();
    }

    /**
     * Проставление внутренних ссылок на сервисы определения пола ребенка
     * со страниц найденных в сфинксе по запросу "определение пола"
     */
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

    /**
     * Проставление внутренних ссылок на сервис гороскоп
     * со страниц найденных в сфинксе по запросу "гороскоп"
     */
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
            echo $from_page->url . "\n";
            $exist = InnerLink::model()->exists('page_id = ' . $from_page->id . ' and page_to_id=' . $page->id);

            if (!$exist) {
                //ссылки нет можно ставить
                echo "Link not exist can be placed\n";
                $link = new InnerLink();
                $link->page_id = $from_page->id;
                $link->page_to_id = $phrase->page_id;
                $link->phrase_id = $phrase->id;
                $link->keyword_id = $keyword->id;
                $link->save();
            } else
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

    /**
     * Синхронизация внутренних ссылок из таблицы inner_linking__links в сео-бд и
     * документами InnerLinksBlock в монго-бд. Дублирование нужно на случай если
     * сео-бд будет недоступна и для ускорения выборки
     */
    public function actionSync()
    {
        Yii::import('site.common.models.mongo.*');

        InnerLinksBlock::model()->Sync($this);
    }

    /**
     * Запуск внутренней перелинковки статей
     */
    public function actionLinks()
    {
        Yii::import('site.seo.modules.promotion.components.*');
        $c = new CLinking();
        $c->start();
    }

    /**
     * Добавление названий рецептов на парсинг в вордстат
     */
    public function actionAddRecipesToParsing()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $recipes = Yii::app()->db->createCommand()
            ->select('id')
            ->from('cook__recipes')
            ->where('removed=0')
            ->queryColumn();

        echo count($recipes) . "\n";
        foreach ($recipes as $recipe) {
            Yii::app()->db_seo->createCommand()->insert('parsing_task__task',
                array('content_id' => $recipe));
        }
    }

    /**
     * Перелинковка рецептов
     */
    public function actionRecipes(){
        Yii::import('site.seo.modules.promotion.components.*');
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.seo.modules.writing.models.*');
        $p = new CRecipeLinking;
        $p->start();
    }

    /**
     * Удаление ссылок настатью / со статьи если она была удалена
     */
    public function actionDeleteRemoved(){
        Yii::import('site.frontend.modules.cook.models.*');
        $pageIds = Yii::app()->db_seo->createCommand()
            ->selectDistinct('page_to_id')
            ->from('inner_linking__links')
            ->queryColumn();

        echo count($pageIds)."\n";
        foreach($pageIds as $pageId){
            $page = Page::model()->findByPk($pageId);
            if (empty($page->entity) || empty($page->entity_id)){
                continue;
            }
            $model = CActiveRecord::model($page->entity)->findByPk($page->entity_id);
            if ($model === null || (isset($model->removed) && $model->removed == 1)){
                //echo $page->entity.' : '.$page->entity_id."\n";
                //$page->delete();
            }else{
                if (strpos($page->url, $model->url) === FALSE){
                    echo $page->url.' -> '.$model->url."\n\n";
                    $page->url = 'http://www.happy-giraffe.ru'.$model->url;
                    $page->update(array('url'));
                }
            }
        }
    }
}