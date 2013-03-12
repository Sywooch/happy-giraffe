<?php
/**
 * Author: alexk984
 * Date: 12.03.13
 */
class CLinking
{
    private $counts = array(0, 0, 0, 0, 0, 0, 0);

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
                        $phrase = PagesSearchPhrase::model()->findByPk($search_phrase_id);
                        $this->SetLinks($phrase);
                    } else
                        $this->counts[5]++;
                }
            }

            $i++;
            echo $this->counts[0] . '-' . $this->counts[1] . '-' . $this->counts[2] . '-' . $this->counts[3] . '-'
                . $this->counts[4] . '-' . $this->counts[5] . "\n";
        }
    }

    /**
     * @param PagesSearchPhrase $phrase
     */
    public function SetLinks($phrase)
    {
        if ($phrase->page->entity == 'CommunityContent') {
            //ставим 3 ссылки по фразе
            $pages = $this->getSimilarArticles($phrase->page, $phrase->keyword->name);

            foreach ($pages as $page) {
                //echo $phrase->page->url . ' - ' . $phrase->keyword->name . ' - ' . $page->url . '<br>';
                $this->counts[0]++;
                $link = new InnerLink();
                $link->keyword_id = $phrase->keyword->id;
                $link->phrase_id = $phrase->id;
                $link->page_id = $page->id;
                $link->page_to_id = $phrase->page->id;
                $link->save();
            }
        } else
            $this->counts[1]++;
    }


    /**
     * @param $current_page
     * @param $name
     * @return Page[]
     */
    public function getSimilarArticles($current_page, $name)
    {
        $sphinx_index = 'communityTextTitle';

        try {
            $allSearch = Yii::app()->search
                ->select('*')
                ->from($sphinx_index)
                ->where(' ' . CHtml::encode($name) . ' ')
                ->limit(0, 100)
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

        $ids = array_unique($ids);
        $pages = array();
        foreach ($ids as $id) {
            $good = true;

            $model = CommunityContent::model()->findByPk($id);
            if ($model === null)
                break;

            $url = 'http://www.happy-giraffe.ru' . $model->getUrl();
            $page = Page::getPage($url);
            if (!$page) {
                echo "page is null: $url \n";
                continue;
            }
            //если другая страница
            if ($page->id == $current_page->id)
                continue;

            //если на странице меньше 3-х ссылок
            if ($page->outputLinksCount >= 3)
                continue;

            //если ссылка с нее уже стоит
            if (InnerLink::model()->exists('page_id = ' . $page->id . ' and page_to_id=' . $current_page->id))
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
                $pages [] = $page;

            if (count($pages) >= 3)
                break;
        }

        if (empty($pages))
            $this->counts[2]++;

        if (count($pages) > 0 && count($pages) < 3)
            $this->counts[3]++;

        return $pages;
    }
}
