<?php
/**
 * Поиск похожих статей для ключевых слов через сфинкс. Нужно для редакции при выборе
 * ключевых слов среди слов конкурентов. Чтобы не искать во время работы программы ищем
 * по крону и храним резуьтаты в бд. Запускается раз в неделю
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class SimilarArticles
{
    /**
     * Разделы сайта, в которых ищем страницы
     * @var array
     */
    private $sections = array(
        1 => array(
            'entity' => 'CommunityContent',
            'index' => 'communityTextTitle',
        ),
        2 => array(
            'entity' => 'CookRecipe',
            'index' => 'recipe',
        ),
    );

    /**
     * Запуск поиска статей
     */
    public function start()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $keywords = $this->loadKeywords();

        foreach ($keywords as $keyword_id)
            if ($this->needSearch($keyword_id)) {
                $posts = $this->findArticles($keyword_id);
                $this->savePosts($keyword_id, $posts);
            }
    }

    /**
     * Выбираем ключевые слова для поиска похожих статей. Статьи выбираются из тех что парсили
     * с других сайтов с частотой заходов > 50
     * @return array
     */
    private function loadKeywords()
    {
        $keywords = Yii::app()->db_seo->createCommand()
            ->select('distinct(keyword_id)')
            ->from('queries')
            ->where('visits > 50')
            ->queryColumn();

        echo count($keywords) . "\n";
        return $keywords;
    }

    /**
     * Проверяем нужен ли поиск статей для этого ключевого слова, основываясь на том есть ли уже в базе
     * статьи для него и давно ли осуществлялся поиск статей. Если давно, то удаляем существующие
     *
     * @param $keyword_id
     * @return bool нужен ли поиск
     */
    private function needSearch($keyword_id)
    {
        $exist = ShpinxArticles::model()->find('keyword_id = :keyword_id', array(':keyword_id' => $keyword_id));
        if ($exist !== null) {
            if (strtotime($exist->updated) < strtotime('-1 month')) {
                echo "delete\n";
                ShpinxArticles::model()->deleteAll('keyword_id = :keyword_id', array(':keyword_id' => $keyword_id));
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Ищем похожие статьи для ключевого слова
     * @param $keyword_id int id ключевого слова, для которого ищем статьи
     * @return array
     */
    private function findArticles($keyword_id)
    {
        $keyword = Keyword::model()->findByPk($keyword_id);
        $keyword = Str::prepareForSphinxSearch($keyword->name);

        $result = array();
        foreach ($this->sections as $section)
            $result = array_merge($result, $this->findInSection($keyword, $section));

        return $result;
    }

    /**
     * Поиск статей по ключевому слову для раздела (Статьи, рецепты)
     *
     * @param $keyword string
     * @param $section array раздел для которого ищем
     * @return CActiveRecord[] список найденных статей, пустой массив если ничего не нашли
     */
    private function findInSection($keyword, $section)
    {
        try {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from($section['index'])
                ->where(' ' . $keyword . ' ')
                ->limit(0, 10)
                ->searchRaw();
        } catch (Exception $e) {
            return array();
        }
        if (empty($allSearch['matches']))
            return array();

        $ids = array_keys($allSearch['matches']);
        $models = CActiveRecord::model($section['entity'])->resetScope()->findAllByPk($ids);

        //проверяем не привязана ли эта статья к другому ключевому слову
        foreach ($models as $key => $model) {
            $url = 'http://www.happy-giraffe.ru' . $model->url;
            $page = Page::model()->with(array('keywordGroup'))->findByAttributes(array('url' => $url));
            if ($page !== null && isset($page->keywordGroup) && !empty($page->keywordGroup->keywords))
                unset($models[$key]);
        }

        return $models;
    }

    /**
     * Сохранение найденных статей в таблицу
     * @param $keyword_id int id ключевого слова, для которого ищем статьи
     * @param $posts CActiveRecord[] список статей, которые нужно сохранить
     */
    private function savePosts($keyword_id, $posts)
    {
        foreach ($posts as $post) {
            Yii::app()->db_seo->createCommand()->insert('shpinx_articles', array(
                'keyword_id' => $keyword_id,
                'entity' => get_class($post),
                'entity_id' => $post->primaryKey,
                'updated' => date("Y-m-d"),
            ));
        }
    }
}