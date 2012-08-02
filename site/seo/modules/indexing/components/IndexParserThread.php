<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class IndexParserThread extends ProxyParserThread
{
    /**
     * @var IndexingUrl
     */
    protected $url;
    /**
     * @var int search engine id
     */
    protected $pages = 10;
    protected $up_id = null;

    function __construct()
    {
        parent::__construct();
        $up = IndexingUp::model()->find(array('order' => 'id desc'));
        $this->up_id = $up->id;
        $this->delay_min = 10;
        $this->delay_max = 15;
    }

    public function start()
    {
        while (true) {
            $this->getUrl();
            $this->parsePage();

            $this->url->active = 2;
            $this->url->save();
            $this->url = null;

            if (Config::getAttribute('stop_threads') == 1)
                break;
        }
    }

    public function perPage()
    {
        return 30;
    }

    public function getUrl()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        //$criteria->compare('type', 1);
        $criteria->order = 'type DESC';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->url = IndexingUrl::model()->find($criteria);
            if ($this->url === null) {
                $this->closeThread('no queries');
            }

            $this->url->active = 1;
            $this->url->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->closeThread('Fail with getting queries');
        }
    }

    public function parsePage()
    {
        $links = $this->loadYandexPage();
        if ($this->debug)
            echo 'Page loaded, links count: ' . count($links) . "\n";

        $this->success_loads++;

        foreach ($links as $link) {
            $this->saveUrl($link);
        }
        //sleep(20);
    }

    private function loadYandexPage()
    {
        $content = $this->query('http://yandex.ru/yandsearch?text=' . urlencode('url:' . rtrim($this->url->url, '/').'*') . '&numdoc=' . $this->perPage() . '&searchid=1883818&lr=38');

        if (strpos($content, 'Искомая комбинация слов нигде не встречается') !== false)
            return array();

        $document = phpQuery::newDocument($content);

        $links = array();
        foreach ($document->find('.b-body-items h2 a.b-serp-item__title-link') as $link) {
            $links [] = pq($link)->attr('href');
        }

        $document->unloadDocument();
        if (empty($links)) {
            $this->changeBadProxy();
            return $this->loadYandexPage();
        }

        return $links;
    }

    private function hasNextLink($document)
    {
        $el = $document->find('div.b-bottom-wizard div.b-pager span.b-pager__arrow:eq(1)');
        if (pq($el)->hasClass('b-pager__inactive'))
            return false;

        return true;
    }

    public function saveUrl($url)
    {
        $model = IndexingUrl::model()->findByAttributes(array('url' => $url));
        if ($model === null) {
            $model = new IndexingUrl;
            $model->url = $url;
        }
        $model->active = 2;
        $model->save();

        $upUrl = IndexingUpUrl::model()->findByAttributes(array(
            'up_id' => $this->up_id,
            'url_id' => $model->id,
        ));
        if ($upUrl === null) {
            $upUrl = new IndexingUpUrl;
            $upUrl->up_id = $this->up_id;
            $upUrl->url_id = $model->id;
            $upUrl->save();
        }
    }

    protected function closeThread($reason)
    {
        if ($this->url !== null) {
            $this->url->active = 0;
            $this->url->save();
        }
        parent::closeThread($reason);
    }

    public static function collectUrls()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.services.modules.names.models.*');
        Yii::import('site.frontend.components.ManyToManyBehavior');
        Yii::import('site.frontend.modules.cook.models.*');

        //Community
        $communities = Community::model()->findAll();
        foreach ($communities as $community) {
            self::addUrl('http://www.happy-giraffe.ru/community/' . $community->id . '/forum/', 1);

            self::addUrl('http://www.happy-giraffe.ru/community/' . $community->id . '/forum/post/', 1);
            foreach (range(1, 9) as $letter)
                self::addUrl('http://www.happy-giraffe.ru/community/' . $community->id . '/forum/post/'.$letter, 1);

            self::addUrl('http://www.happy-giraffe.ru/community/' . $community->id . '/forum/video/', 1);
            foreach (range(1, 9) as $letter)
                self::addUrl('http://www.happy-giraffe.ru/community/' . $community->id . '/forum/video/'.$letter, 1);
        }

        //блоги сотрудников
        $users = User::model()->findAll('t.group > 0 AND t.deleted = 0');
        foreach($users as $user)
            self::addUrl('http://www.happy-giraffe.ru/user/' . $user->id . '/blog/', 1);

        //morning
        $morning = array_merge(range(14,21), range(146,213));
        foreach($morning as $letter)
            self::addUrl('http://www.happy-giraffe.ru/morning/' . $letter, 1);

        //весь контент
        $articles = array(1);
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $i = 0;
        while (!empty($articles)) {
            $articles = CommunityContent::model()->full()->active()->findAll($criteria);
            foreach ($articles as $article) {
                $url = $article->getUrl();
                $url = trim($url, '.');
                self::addUrl('http://www.happy-giraffe.ru' . $url);
            }
            $i++;
            $criteria->offset = $i * 100;
        }

        //services
        self::addUrl('http://www.happy-giraffe.ru/names/saint/');
        self::addUrl('http://www.happy-giraffe.ru/names/top10/');
        foreach (range('A', 'Z') as $letter)
            self::addUrl('http://www.happy-giraffe.ru/names/'.$letter, 1);
        self::addUrl('http://www.happy-giraffe.ru/names/');
        $names = Name::model()->findAll();
        foreach ($names as $name)
            self::addUrl('http://www.happy-giraffe.ru/names/' . $name->slug . '/');


        self::addUrl('http://www.happy-giraffe.ru/babySex/');
        self::addUrl('http://www.happy-giraffe.ru/sewing/');

        self::addUrl('http://www.happy-giraffe.ru/horoscope/');
        self::addUrl('http://www.happy-giraffe.ru/horoscope/compatibility/');
        foreach (array('a', 't','g', 'c', 'l', 'v', 's', 'p') as $letter)
            self::addUrl('http://www.happy-giraffe.ru/horoscope/'.$letter, 1);
        foreach (array('a', 't','g', 'c', 'l', 'v', 's', 'p') as $letter)
            self::addUrl('http://www.happy-giraffe.ru/horoscope/compatibility/'.$letter, 1);

        self::addUrl('http://www.happy-giraffe.ru/test/');
        self::addUrl('http://www.happy-giraffe.ru/pregnancyWeight/');
        self::addUrl('http://www.happy-giraffe.ru/placentaThickness/');
        self::addUrl('http://www.happy-giraffe.ru/menstrualCycle/');
        self::addUrl('http://www.happy-giraffe.ru/babyBloodGroup/');
        self::addUrl('http://www.happy-giraffe.ru/contractionsTime/');

        self::addUrl('http://www.happy-giraffe.ru/childrenDiseases/');
        foreach (range('a', 'z') as $letter)
            self::addUrl('http://www.happy-giraffe.ru/childrenDiseases/' . $letter, 1);
        $models = RecipeBookDisease::model()->findAll();
        foreach ($models as $model)
            self::addUrl('http://www.happy-giraffe.ru/childrenDiseases/' . $model->slug . '/');
        $models = RecipeBookDiseaseCategory::model()->findAll();
        foreach ($models as $model)
            self::addUrl('http://www.happy-giraffe.ru/childrenDiseases/' . $model->slug . '/');

        // Cook recipes
        self::addUrl('http://www.happy-giraffe.ru/cook/recipe/');
        foreach (range(1, 999) as $letter)
            self::addUrl('http://www.happy-giraffe.ru/cook/recipe/' . $letter, 1);
        $models = CookRecipe::model()->findAll();
        foreach ($models as $model)
            self::addUrl('http://www.happy-giraffe.ru/cook/recipe/' . $model->id . '/');

        self::addUrl('http://www.happy-giraffe.ru/cook/converter/');
        self::addUrl('http://www.happy-giraffe.ru/cook/calorisator/');

        // Cook choose
        foreach (range('a', 'z') as $letter)
            self::addUrl('http://www.happy-giraffe.ru/cook/choose/' . $letter, 1);
        $models = CookChoose::model()->findAll();
        foreach ($models as $model)
            self::addUrl('http://www.happy-giraffe.ru/cook/choose/' . $model->slug . '/');
        $models = CookChooseCategory::model()->findAll();
        foreach ($models as $model)
            self::addUrl('http://www.happy-giraffe.ru/cook/choose/' . $model->slug . '/');

        // Cook spices
        foreach (range('a', 'z') as $letter)
            self::addUrl('http://www.happy-giraffe.ru/cook/spice/' . $letter, 1);
        $models = CookSpice::model()->findAll();
        foreach ($models as $model)
            self::addUrl('http://www.happy-giraffe.ru/cook/spice/' . $model->slug . '/');
        $models = CookSpiceCategory::model()->findAll();
        foreach ($models as $model)
            self::addUrl('http://www.happy-giraffe.ru/cook/spice/' . $model->slug . '/');

        self::addUrl('http://www.happy-giraffe.ru/cook/decor/');
        for ($i = 0; $i <= 7; $i++) {
            self::addUrl('http://www.happy-giraffe.ru/cook/decor/' . $i . '/', 1);
        }
    }

    public static function addUrl($url, $type = 0)
    {
        $model = IndexingUrl::model()->findByAttributes(array('url' => $url));
        if ($model === null) {
            $model = new IndexingUrl;
            $model->url = $url;
            $model->type = $type;
            $model->active = 0;
            $model->save();
        }else{
            if ($type != 0 && $model->type != $type){
                $model->type = $type;
                $model->save();
            }
        }
    }
}
