<?php
/**
 * Author: alexk984
 * Date: 12.03.13
 */
class CRecipeLinking
{
    public $bad_words = array("купить", "елена чкалова", "елены чекаловой", "видео", "музыка", "say7", "точка ру",
        "фильм", "магазин", "ооо", "цена", "википедия", "ресторан", "москв", "петербург", "новосибирск", "екатеринбург",
        "новгород", "самара", "самаре", "казань", "казани", "омск", "челябинск", "ростов", "уфа", "уфе", "волгоград",
        "пермь", "красноярск", "воронеж", "саратов", "краснодар", "тольятти", "ижевск", "барнаул", "ульяновск",
        "тюмень", "тюмени", "иркутск", "владивосток", "ярославл", "хабаровск", "махачкал", "оренбург", "новокузнецк",
        "томск", "кемерово", "рязан", "астрахан", "пенз", "липецк", "готовим ру", 'кафе');

    private $counts = array(0, 0, 0, 0, 0, 0, 0);
    private $links_count = array(0, 0, 0);
    /**
     * @var CookRecipe
     */
    public $recipe;
    /**
     * @var Page
     */
    public $page;

    public function start()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = CookRecipe::model()->findAll($criteria);

            foreach ($models as $model) {
                $this->recipe = $model;
                $this->page = Page::getPage('http://www.happy-giraffe.ru' . $this->recipe->getUrl());

                //1 ссылку по названию
                //$this->createLinkByName();
                //1 ссылку по тем на которые рассчитывали
                //$this->createPlannedKeywordLink();
                //ставим 3 ссылки с ключевыми словами из wordstat
                $this->createFoundKeywordsLinks();
            }
            $criteria->offset += 100;

            echo "done: " . $this->counts[0] . ", page not found: " . $this->counts[2] . ", link exist: " . $this->counts[3] . "\n";
            echo $this->links_count[0] . ' - ' . $this->links_count[1] . ' - ' . $this->links_count[2] . "\n";
        }
    }

    /**
     * Добавить 1 ссылку по названию
     */
    public function createLinkByName()
    {
        $keyword = Keyword::GetKeyword($this->recipe->title);
        if ($keyword !== null)
            $this->links_count[0]++;
        $this->createLink($keyword);
    }

    /**
     * Ставим ссылку с ключевым словом по которому писалась статья
     */
    public function createPlannedKeywordLink()
    {
        $keyword = $this->getPlanedKeyword();
        if ($keyword !== null)
            $this->links_count[1]++;
        $this->createLink($keyword);
    }

    /**
     * ставим 2 ссылки с ключевыми словами из wordstat
     */
    private function createFoundKeywordsLinks()
    {
        //если одно слова - пропускаем
        if (strpos($this->recipe->title, ' ') === false)
            return;

        $keywords = $this->getFoundKeywords();
        foreach ($keywords as $keyword) {
            $this->links_count[2]++;
            $this->createLink($keyword);
        }
    }

    /**
     * Выбираем 3 ключевых слова, которые нашли по wordstat
     */
    public function getFoundKeywords()
    {
        //выбраем все слова
        $keywords = Yii::app()->db_seo->createCommand()
            ->select('keyword_id, name')
            ->from('parsing_task__keywords as t')
            ->join('keywords.keywords as keywords', 'keywords.id = t.keyword_id')
            ->where('content_id = :content_id AND keywords.name != :name AND keywords.wordstat > 100',
                array(':content_id' => $this->recipe->id, ':name' => mb_strtolower($this->recipe->title)))
            ->limit(300)
            ->order('keywords.wordstat')
            ->queryAll();

        //фильтруем
        $good_keywords = array();
        foreach ($keywords as $keyword) {
            //если в слове есть "мультиварк" но рецепт не для мультиварок - пропускаем
            if ($this->recipe->section != 1 && strpos($keyword['name'], 'мульварк') !== false)
                continue;

            //если слово уже использовалось в перелинковке - пропускаем
            $exist = InnerLink::model()->findByAttributes(array('keyword_id' => $keyword['keyword_id']));
            if ($exist !== null) {
                //echo $keyword['name'].' - использовано<br>';
                continue;
            }

            //проверяем на стоп-слова
            $good = true;
            foreach ($this->bad_words as $bad_word)
                //если какое-либо слово встречается и при этом его нет в названии самого рецепты - пропускаем
                if (strpos($keyword['name'], $bad_word) !== false && strpos($this->recipe->title, $bad_word) === false)
                    $good = false;

            if ($good) {
                //проверяем что рецепта с таким названием нету
                if (!$this->keywordUsedOnSomeTitle($keyword['name'])) {
                    $good_keywords [] = $keyword['keyword_id'];
                } else {
                    //echo $keyword['name'].' - рецепт с этим названием есть<br>';
                }
            } else {
                //echo $keyword['name'].' - стоп-слова<br>';
            }

            if (count($good_keywords) >= 10)
                break;
        }

        if (empty($good_keywords))
            return array();

        return Keyword::model()->findAllByPk($good_keywords);
    }

    /**
     * Возвращает ключевое слово по которому писалась статья
     *
     * @return null|Keyword
     */
    public function getPlanedKeyword()
    {
        $task = SeoTask::model()->findByAttributes(array('article_id' => $this->page->id));
        if ($task !== null && !empty($task->keywordGroup)) {
            if (isset($task->keywordGroup->keywords[0]))
                return $task->keywordGroup->keywords[0];
        }
        $this->counts[4]++;
        return null;
    }

    /**
     * По ключевому слову ищет рецепт для проставления ссылки и ставит с нее ссылку
     *
     * @param $keyword
     */
    private function createLink($keyword)
    {
        if ($keyword !== null) {
            //проверяем нет ли ссылки на этот рецепт с таким анкором
            $already = InnerLink::model()->find('page_to_id=' . $this->page->id . ' AND keyword_id=' . $keyword->id);
            if ($already !== null) {
                $this->counts[3]++;
                return;
            }

            //получаем страницу с которых можно проставить ссылки
            $page = $this->getSimilarArticles($keyword->name);
            $this->saveLink($keyword, $page);
        }
    }

    /**
     * Получить страницу-донор из сфинкс которая лучше всего подходит к названию текущего рецепта
     *
     * @param $name
     * @return Page[]
     */
    public function getSimilarArticles($name)
    {
        //ищем по точному вхождению
        $ids = $this->getArticlesFromSphinx($name);
        $page = $this->getSuitableRecipe($ids);

        if ($page === null) {
            //ищем по неточному вхождению
            $ids = $this->getArticlesFromSphinx($name, SPH_MATCH_ANY);
            $page = $this->getSuitableRecipe($ids);
        }

        return $page;
    }


    /**
     * Проанализировать страницы найденные в sphinx на возможность быть донором для текущей страницы
     *
     * @param $ids
     * @internal param $name
     * @return Page[]
     */
    public function getSuitableRecipe($ids)
    {
        foreach ($ids as $id) {
            $model = CookRecipe::model()->findByPk($id);
            //если удален
            if ($model === null)
                continue;

            //если другая секция (мультиварка / обычные)
            if ($model->section != $this->recipe->section)
                continue;

            $url = 'http://www.happy-giraffe.ru' . $model->getUrl();
            $page = Page::getPage($url);
            if (!$page) {
                echo "page is null: $url \n";
                continue;
            }

            //если на странице 3 или больше ссылок
            if ($page->outputLinksCount >= 3)
                continue;

            //если ссылка с нее уже стоит
            if ($page->id == 18106 && $this->page->id == 49276)
                echo 'check link exist';

            if (InnerLink::model()->exists('page_id = :page_from and page_to_id=:page_to',
                array(':page_from' => $page->id, ':page_to' => $this->page->id))
            )
                continue;
            else{
                if ($page->id == 18106 && $this->page->id == 49276)
                    echo ' link  not exist ';
            }

            $good = true;
            $links_from_page = $model->getMore();
            foreach ($links_from_page as $link_from_page)
                if ($link_from_page->id == $this->recipe->id)
                    $good = false;

            if ($good)
                return $page;
        }

        return null;
    }

    /**
     * Ищем рецепты-доноры
     *
     * @param $name string ключевое слово
     * @param null|int $mode точное совпадение фразы или частичное
     * @return array
     */
    public function getArticlesFromSphinx($name, $mode = null)
    {
        try {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from('recipe')
                ->setMatchMode(empty($mode) ? SPH_MATCH_EXTENDED2 : $mode)
                ->where(' ' . CHtml::encode($name) . ' ')
                ->limit(0, 300)
                ->searchRaw();
        } catch (Exception $e) {
            echo 'exception!';
            return array();
        }

        $ids = array();
        foreach ($allSearch['matches'] as $key => $m)
            if ($key != $this->recipe->id)
                $ids [] = $key;

        return $ids;
    }

    public function testGetArticlesFromSphinx()
    {
        $this->recipe = CookRecipe::model()->find(array('limit' => 100, 'order' => 'rand()'));
        echo $this->recipe->title . '<br>';
        $recipes = $this->getArticlesFromSphinx($this->recipe->title);
        foreach ($recipes as $recipe_id) {
            $recipe = CookRecipe::model()->findByPk($recipe_id);
            echo $recipe->title . ' - ';
        }
        echo '<br>';
    }


    /**
     * Проверяем заголовки всех рецептов - нет ли в них ключевого слова, которое мы хотим использовать
     * для продвижения рецепта
     *
     * Пример: наш рецепт называется "салат оливье", ключевое слова "салат оливье с курицей"
     * но такой рецепт уже есть, поэтому ошибочно продвигать его по этому ключевому слову
     *
     * @param $name string ключевое слово для проверки
     * @return bool
     */
    public function keywordUsedOnSomeTitle($name)
    {
        $allSearch = Yii::app()->search
            ->select('*')
            ->from('recipeTitle')
            ->setMatchMode(SPH_MATCH_ALL)
            ->where(' ' . CHtml::encode($name) . ' ')
            ->limit(0, 10)
            ->searchRaw();

        foreach ($allSearch['matches'] as $key => $m)
            if ($key != $this->recipe->id) {
                $r = CookRecipe::model()->findByPk($key);

                if ($r === null) //рецепт может быть уже удален
                    continue;

                //хак - проверяем длины строк чтобы в названии не было дополнительных слов
                if (abs(strlen($r->title) - strlen($this->recipe->title)) < 6)
                    return true;
            }
        return false;
    }

    public function testKeywordUsedOnSomeTitle()
    {
        $recipes = CookRecipe::model()->findAll(array('limit' => 100));
        foreach ($recipes as $recipe) {
            $this->recipe = $recipe;
            echo $recipe->title . ' - ';
            echo $this->keywordUsedOnSomeTitle($recipe->title) ? ' +++ ' : ' --- ';
            echo '<br>';
        }
    }


    /**
     * Создать в бд ссылку со страницы $page на текущую страницу с ключевым словом $keyword
     *
     * @param $keyword
     * @param $page
     */
    private function saveLink($keyword, $page)
    {
        if ($page === null || $keyword === null) {
            $this->counts[2]++;
            return;
        }

        $link = new InnerLink();
        $link->keyword_id = $keyword->id;
        $link->page_id = $page->id;
        $link->page_to_id = $this->page->id;
        $link->save();
        $this->counts[0]++;
    }
}
