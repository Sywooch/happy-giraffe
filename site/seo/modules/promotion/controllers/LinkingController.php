<?php

Yii::import('site.frontend.extensions.phpQuery.phpQuery');

class LinkingController extends SController
{
    public $pageTitle = 'продвижение';
    public $layout = '//layouts/promotion';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser')
            && !Yii::app()->user->checkAccess('editor') && !Yii::app()->user->checkAccess('promotion')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionView($id, $selected_phrase_id = null, $period = 1)
    {
        $page = $this->loadPage($id);

        $this->render('view', compact('page', 'selected_phrase_id', 'period'));
    }

    public function actionAutoLinking()
    {
        $phrase = PagesSearchPhrase::getActualPhrase();

        $parser = new SimilarArticlesParser;
        $pages = $parser->getArticles($phrase->keyword->name);
        $keywords = $phrase->getSimilarKeywords();

        $this->render('auto_linking', compact('phrase', 'pages', 'keywords'));
    }

    public function actionSkip()
    {
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));
        $skip = new ILSkip;
        $skip->phrase_id = $phrase->id;
        if (!$skip->save()){
            echo CJSON::encode(array(
                'status' => false,
                'error' => $skip->getErrorsText(),
            ));
            Yii::app()->end();
        }

        $response = $this->nextLink();
        echo CJSON::encode($response);
    }

    public function actionAdd()
    {
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));
        $page_from = $this->loadPage(Yii::app()->request->getPost('page_id'));
        $keyword_id = Yii::app()->request->getPost('keyword_id');
        if ($keyword_id == 'null') {
            $keyword = Yii::app()->request->getPost('keyword');
            $keyword = Keyword::GetKeyword($keyword);
            $keyword_id = $keyword->id;
        }

        $link = new InnerLink();
        $link->page_id = $page_from->id;
        $link->page_to_id = $phrase->page_id;
        $link->phrase_id = $phrase->id;
        $link->keyword_id = $keyword_id;

        if (!$link->save()) {
            echo CJSON::encode(array(
                'status' => false,
                'error' => $link->getErrorsText(),
            ));
        } else {

            if (Yii::app()->request->getPost('next_link') == 1) {
                $response = $this->nextLink();
            } else
                $response = array(
                    'status' => true,
                    'linkInfo' => $this->renderPartial('_link_info', array('input_link' => $link), true)
                );
            echo CJSON::encode($response);
        }
    }

    public function nextLink()
    {
        $phrase = PagesSearchPhrase::getActualPhrase();
        $page = $phrase->page;
        $pages = $this->getSimilarPages($phrase);
        $keywords = $phrase->getSimilarKeywords();

        return array(
            'status' => true,
            'html' => $this->renderPartial('_auto_linking', compact('phrase', 'pages', 'keywords', 'page'), true),
            'page_id' => $page->id,
            'phrase_id' => $phrase->id,
        );
    }

    public function actionPhraseInfo()
    {
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));
        $pages = $this->getSimilarPages($phrase);

        $keywords = $phrase->getSimilarKeywords();

        $this->renderPartial('_phrase_view', compact('pages', 'keywords', 'phrase'));
    }


    /**
     * @param $phrase
     * @return Page[]
     */
    public function getSimilarPages($phrase)
    {
        $parser = new SimilarArticlesParser;
        $pages = $parser->getArticles($phrase->keyword->name);

        $pages = $this->filterPages($phrase, $pages);
        if (empty($pages)) {
            //если яндекс не нашел статьи по запросу - выводим статьи из рубрики
            $url = $phrase->page->getRubricUrl();
            $pages = $parser->getArticles($url);
        }
        $pages = $this->filterPages($phrase, $pages);

        if (empty($pages)) {
            $pages = $parser->getArticles('http://www.happy-giraffe.ru/community/');
            $pages = $this->filterPages($phrase, $pages);
        }

        if (count($pages) > 10)
            $pages = array_slice($pages, 0, 10);

        return $pages;
    }

    /**
     * @param PagesSearchPhrase $phrase
     * @param Page[] $pages
     * @return mixed
     */
    private function filterPages($phrase, $pages)
    {
        //удалим текущий
        foreach ($pages as $key => $page) {
            if ($page->id == $phrase->page_id)
                unset($pages[$key]);
        }
        //удалим те с которых уже стоят ссылки на наш
        foreach ($pages as $key => $page) {
            if (!empty($page->id) && InnerLink::model()->exists('page_id = ' . $page->id . ' and page_to_id=' . $phrase->page->id))
                unset($pages[$key]);
        }
        //удалим те, с которых стоят ссылки на наш в разделе "Ещё статьи на эту тему"
        foreach ($pages as $key => $page) {
            $article = $phrase->page->getArticle();
            $our_article = $page->getArticle();
            if (!empty($article) && !empty($our_article)) {
                $post = $article->getPrevPost();
                if ($post !== null && $post->id == $our_article->id)
                    unset($pages[$key]);
                $post = $article->getNextPost();
                if ($post !== null && $post->id == $our_article->id)
                    unset($pages[$key]);
            }
        }

        return $pages;
    }

    public function actionRemove()
    {
        $page_id = Yii::app()->request->getPost('page_id');
        $page_to_id = Yii::app()->request->getPost('page_to_id');
        InnerLink::model()->deleteAllByAttributes(array(
            'page_id' => $page_id,
            'page_to_id' => $page_to_id
        ));

        echo CJSON::encode(array('status' => true));
    }

    public function actionStats()
    {
        $period = Yii::app()->request->getPost('period');
        $page = $this->loadPage(Yii::app()->request->getPost('page_id'));
        $goodPhrases = $page->goodPhrases();
        $selected_phrase_id = Yii::app()->request->getPost('phrase_id');

        $this->renderPartial('_stats', compact('period', 'goodPhrases', 'selected_phrase_id'));
    }

    public function actionDonors()
    {
        $page = $this->loadPage(Yii::app()->request->getPost('page_id'));
        $links = $page->inputLinks;
        $this->renderPartial('_donors', compact('links'));
    }

    public function actionPositions()
    {
        $se = Yii::app()->request->getPost('se');
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));
        $positions = $phrase->getPositionsArray($se);
        $this->renderPartial('_positions', compact('positions', 'se'));
    }

    public function actionSearchPages()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $keyword = Yii::app()->request->getPost('keyword');
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));

        $parser = new SimilarArticlesParser;
        $pages = $parser->getArticles($keyword);

        $pages = $this->filterPages($phrase, $pages);

        if (count($pages) > 10)
            $pages = array_slice($pages, 0, 10);

        $this->renderPartial('_pages', compact('pages'));
    }

    /**
     * @param int $id model id
     * @return Keyword
     * @throws CHttpException
     */
    public function loadKeyword($id)
    {
        $model = Keyword::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id model id
     * @return PagesSearchPhrase
     * @throws CHttpException
     */
    public function loadPhrase($id)
    {
        $model = PagesSearchPhrase::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id model id
     * @return Page
     * @throws CHttpException
     */
    public function loadPage($id)
    {
        $model = Page::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Page id not found.');
        return $model;
    }
}