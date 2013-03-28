<?php
/**
 * Author: alexk984
 * Date: 12.03.13
 */
class CLinking
{
    const LINKS_COUNT = 3;
    private $counts = array(0, 0, 0, 0, 0, 0, 0);
    /**
     * @var PagesSearchPhrase
     */
    private $phrase;

    public function start()
    {
        $keywords = 33;
        $i = 0;
        while (!empty($keywords)) {
            $keywords = Yii::app()->db_seo->createCommand()
                ->select('keyword_id')
                ->from('parsing_positions')
                ->limit(100)
                ->offset($i * 100)
                ->queryColumn();

            foreach ($keywords as $keyword_id) {
                //находим страницу на которую ведет ключевое слово
                $phrases = Yii::app()->db_seo->createCommand()
                    ->select('id')
                    ->from('pages_search_phrases')
                    ->where('keyword_id = ' . $keyword_id)
                    ->queryColumn();

                if (!empty($phrases)) {
                    $search_phrase_id = Yii::app()->db_seo->createCommand()
                        ->select('search_phrase_id')
                        ->from('pages_search_phrases_positions')
                        ->where('search_phrase_id IN (' . implode(',', $phrases) . ')')
                        ->order('date DESC')
                        ->queryScalar();

                    if (!empty($search_phrase_id)) {
                        $this->phrase = PagesSearchPhrase::model()->findByPk($search_phrase_id);
                        $this->SetLinks();
                    } else
                        $this->counts[5]++;
                }
            }

            $i++;
            echo $this->counts[0] . '-' . $this->counts[1] . '-' . $this->counts[2] . '-' . $this->counts[3] . '-'
                . $this->counts[4] . '-' . $this->counts[5] . "\n";
        }
    }

    public function SetLinks()
    {
        if ($this->phrase->page->entity == 'CommunityContent') {
            //может уже есть ссылки по этому ключевому слову
            $already_count = InnerLink::model()->count('page_to_id=' . $this->phrase->page->id
                . ' AND keyword_id=' . $this->phrase->keyword->id);

            //если ссылок на этому ключу меньше 3-х
            if ($already_count < self::LINKS_COUNT) {
                //получаем страницы с которых можно проставить ссылки
                $pages = $this->getSimilarArticles($this->phrase->keyword->name, self::LINKS_COUNT - $already_count);

                foreach ($pages as $page) {
                    $link = new InnerLink();
                    $link->keyword_id = $this->phrase->keyword->id;
                    $link->phrase_id = $this->phrase->id;
                    $link->page_id = $page->id;
                    $link->page_to_id = $this->phrase->page->id;
                    $link->save();
                    $this->counts[0]++;
                }
            }
        } else
            $this->counts[1]++;
    }


    /**
     * @param $name
     * @param $count
     * @return Page[]
     */
    public function getSimilarArticles($name, $count)
    {
        $ids = $this->getArticlesFromSphinx($name);
        $pages = array();
        $pages = $this->getSuitablePages($ids, $pages);

        if (count($pages) < $count) {
            $ids = $this->getArticlesFromSphinx($name, SPH_MATCH_ANY);
            $pages = $this->getSuitablePages($ids, $pages, true);
        }

        $pages = array_slice($pages, 0, 3);

        return $pages;
    }

    /**
     * @param array $ids
     * @param $pages
     * @param bool $same_community
     * @return Page[]
     */
    public function getSuitablePages($ids, $pages, $same_community = false)
    {
        $article = $this->phrase->page->getArticle();
        if ($same_community && !isset($article->rubric->community_id))
            return $pages;

        foreach ($ids as $id) {
            $good = true;

            $model = CommunityContent::model()->findByPk($id);
            if ($model === null)
                continue;

            if ($same_community) {
                if ($article == null) {
                    echo $this->phrase->page->url . " - no article found \n";
                    continue;
                }
                if (!isset($model->rubric->community_id))
                    continue;

                if ($model->rubric->community_id != $article->rubric->community_id)
                    continue;
            }

            $url = 'http://www.happy-giraffe.ru' . $model->getUrl();
            $page = Page::getPage($url);
            if (!$page) {
                echo "page is null: $url \n";
                continue;
            }
            //если только что уже добавили
            if (isset($pages[$page->id]))
                continue;

            //если таже страница
            if ($page->id == $this->phrase->page->id)
                continue;

            //если на странице 3 или больше ссылок
            if ($page->outputLinksCount >= 3)
                continue;

            //если ссылка с нее уже стоит
            if (InnerLink::model()->exists('page_id = ' . $page->id . ' and page_to_id=' . $this->phrase->page->id))
                continue;

            foreach (array('getPrevPost', 'getNextPost') as $method)
                if (method_exists($model, $method)) {
                    $post = $model->$method();
                    if ($post !== null) {
                        $url = 'http://www.happy-giraffe.ru' . $post->getUrl(false);
                        if ($page->url == $url)
                            $good = false;
                    }
                }

            if ($good)
                $pages [$page->id] = $page;

            if (count($pages) >= self::LINKS_COUNT)
                break;
        }

        return $pages;
    }


    public function getArticlesFromSphinx($name, $mode = null)
    {
        try {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from('communityTextTitle')
                ->setMatchMode(empty($mode) ? SPH_MATCH_EXTENDED2 : $mode)
                ->where(' ' . CHtml::encode($name) . ' ')
                ->limit(0, 500)
                ->searchRaw();
        } catch (Exception $e) {
            echo 'exception!';
            return array();
        }
        if (empty($allSearch['matches'])) {
            if (empty($pages))
                $this->counts[4]++;

            return array();
        }

        $ids = array();
        foreach ($allSearch['matches'] as $key => $m)
            $ids [] = $key;

        return $ids;
    }
}
