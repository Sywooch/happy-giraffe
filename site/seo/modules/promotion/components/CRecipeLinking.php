<?php
/**
 * Author: alexk984
 * Date: 12.03.13
 */
class CRecipeLinking
{
    private $counts = array(0, 0, 0, 0, 0, 0, 0);
    /**
     * @var CookRecipe
     */
    private $recipe;
    /**
     * @var Page
     */
    private $page;

    public function start()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 300;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = CookRecipe::model()->findAll($criteria);

            foreach ($models as $model) {
                $this->recipe = $model;
                $this->page = Page::getPage('http://www.happy-giraffe.ru' . $this->recipe->getUrl());

                //1 ссылку по названию
                $this->createLinkByName();
                //1 ссылку по тем на которые рассчитывали

            }
            $criteria->offset += 100;

            echo "done: " . $this->counts[0] . ", add keyword fail: " . $this->counts[1] . ", page not found: " . $this->counts[2] . ", link exist: " . $this->counts[3] . "\n";
            Yii::app()->end();
        }
    }

    public function getPlanedKeyword()
    {

    }

    /**
     * Добавить 1 ссылку по названию
     */
    public function createLinkByName()
    {
        //проверяем нет ли ссылки на этот рецепт с таким анкором
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->recipe->title);
        $keyword = Keyword::model()->find($criteria);
        if ($keyword !== null) {
            $already = InnerLink::model()->count('page_to_id=' . $this->page->id . ' AND keyword_id=' . $keyword->id);
            if (!empty($already)) {
                $this->counts[3]++;
                return;
            }
        } else {
            $keyword = new Keyword;
            $keyword->name = $this->recipe->title;
            $keyword->save();

            if ($keyword === null) {
                $this->counts[1]++;
                return;
            }
        }

        //получаем страницу с которых можно проставить ссылки
        $page = $this->getSimilarArticles($keyword->name);

        $this->saveLink($keyword, $page);
    }

    /**
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
            //если только что уже добавили
            if (isset($pages[$page->id]))
                continue;

            //если на странице 3 или больше ссылок
            if ($page->outputLinksCount >= 3)
                continue;

            //если ссылка с нее уже стоит
            if (InnerLink::model()->exists('page_id = ' . $page->id . ' and page_to_id=' . $this->page->id))
                continue;

            $links_from_page = $model->getMore();
            foreach ($links_from_page as $link_from_page)
                if ($link_from_page->id == $this->recipe->id)
                    continue(2);

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
            ->setMatchMode(SPH_MATCH_EXTENDED2)
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
