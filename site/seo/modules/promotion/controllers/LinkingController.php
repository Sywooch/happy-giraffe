<?php

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

        if ($phrase === null) {
            $this->render('auto_linking_empty');
        } else {

            $pages = $this->getSimilarPages($phrase);

            TimeLogger::model()->startTimer('getSimilarKeywords');
            $keywords = $phrase->getSimilarKeywords();
            TimeLogger::model()->endTimer();

            $this->render('auto_linking', compact('phrase', 'pages', 'keywords'));
        }
    }

    public function actionCheckLinks(){
        $link = new InnerLink();
        if(isset($_GET['InnerLink']))
            $link->attributes=$_GET['InnerLink'];

        $this->render('check_links', compact('link'));
    }

    public function actionSkip()
    {
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));
        $skip = new ILSkip;
        $skip->phrase_id = $phrase->id;
        if (!$skip->save()) {
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
        $time = microtime();
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

            $time = microtime() - $time;
            if (Yii::app()->request->getPost('next_link') == 1) {
                $response = $this->nextLink($time);
            } else
                $response = array(
                    'status' => true,
                    'linkInfo' => $this->renderPartial('_link_info', array('input_link' => $link), true)
                );
            echo CJSON::encode($response);
        }
    }

    public function nextLink($time)
    {
        $phrase = PagesSearchPhrase::getActualPhrase();
        $page = $phrase->page;

        $pages = $this->getSimilarPages($phrase);

        TimeLogger::model()->startTimer('getSimilarKeywords');
        $keywords = $phrase->getSimilarKeywords();
        TimeLogger::model()->endTimer();

        return array(
            'status' => true,
            'html' => $this->renderPartial('_auto_linking', compact('phrase', 'pages', 'keywords', 'page', 'time'), true),
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
     * @param PagesSearchPhrase $phrase
     * @return Page[]
     */
    public function getSimilarPages($phrase)
    {
        //check parsed phrases
        $criteria = new CDbCriteria;
        $criteria->compare('keyword_id', $phrase->keyword_id);
        $criteria->limit = 50;
        TimeLogger::model()->startTimer('find pages from parsed');
        $pages = YandexSearchResult::model()->findAll($criteria);
        TimeLogger::model()->endTimer();

        if (!empty($pages)) {
            $res = array();
            foreach ($pages as $page)
                $res [] = $page->page;
            TimeLogger::model()->startTimer('pages found - filter');
            $pages = $this->filterPages($phrase, $res);
            TimeLogger::model()->endTimer();

        } else {
            TimeLogger::model()->startTimer('pages not found - parsing');
            $parser = new SimilarArticlesParser;

            if ($this->startsWith($phrase->page->url, 'http://www.happy-giraffe.ru/horoscope/')) {
                $pages = $parser->getArticles('inurl:community гороскоп');
                $pages = $this->filterPages($phrase, $pages);
            } else {
                $pages = $parser->getArticles($phrase->keyword->name);
                $pages = $this->filterPages($phrase, $pages);
            }
            TimeLogger::model()->endTimer();
        }

        if (empty($pages)) {
            //если яндекс не нашел статьи по запросу - выводим статьи из рубрики
            TimeLogger::model()->startTimer('pages not found - search by rubric');
            $url = $phrase->page->getRubricUrl();

            $parser = new SimilarArticlesParser;
            $pages = $parser->getArticles($url);
            $pages = $this->filterPages($phrase, $pages);
            TimeLogger::model()->endTimer();
        }

        if (count($pages) > 10)
            $pages = array_slice($pages, 0, 20);

        return $pages;
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @param PagesSearchPhrase $phrase
     * @param Page[] $pages
     * @return mixed
     */
    private function filterPages($phrase, $pages)
    {
        //удалим дубликаты
        $exist = array();
        foreach ($pages as $key => $page) {
            if (in_array($page->id, $exist))
                unset($pages[$key]);
            else
                $exist[] = $page->id;
        }

        //удалим текущий
        foreach ($pages as $key => $page)
            if ($page->id == $phrase->page_id)
                unset($pages[$key]);

        //оставим только те с которых можно ставить ссылки
        foreach ($pages as $key => $page)
            if (!$page->CanBeLinkDonor())
                unset($pages[$key]);

        //удалим c которых по 3 ссылки и более
        foreach ($pages as $key => $page)
            if ($page->outputLinksCount >= 3)
                unset($pages[$key]);

        //удалим те с которых уже стоят ссылки на наш
        foreach ($pages as $key => $page) {
            if (!empty($page->id) && InnerLink::model()->exists('page_id = ' . $page->id . ' and page_to_id=' . $phrase->page->id))
                unset($pages[$key]);
        }

        //удалим те, с которых стоят ссылки на наш "Следующая", "Предыдущая"
        $article = $phrase->page->getArticle();
        if (!empty($article)) {
            foreach (array('getPrevPost', 'getNextPost') as $method)
            if (method_exists ($article, $method)){
                $post = $article->$method();
                if ($post !== null) {
                    $ulr = 'http://www.happy-giraffe.ru' . $post->getUrl(false);
                    foreach ($pages as $key => $page) {
                        if ($page->url == $ulr)
                            unset($pages[$key]);
                    }
                }
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
        $links = InnerLink::model()->findAllByAttributes(array('phrase_id' => Yii::app()->request->getPost('phrase_id')));
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
        $keyword = Yii::app()->request->getPost('keyword');
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));

        $parser = new SimilarArticlesParser;
        $pages = $parser->getArticles($keyword);

        $pages = $this->filterPages($phrase, $pages);

        if (count($pages) > 10)
            $pages = array_slice($pages, 0, 10);

        $this->renderPartial('_pages', compact('pages'));
    }

    public function actionSaveSettings()
    {
        foreach ($_POST as $key => $attr) {
            SeoUserAttributes::setAttribute($key, $attr);
        }

        echo CJSON::encode(array('status' => true));
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