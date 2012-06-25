<?php

class LinkingController extends SController
{
    public $pageTitle = 'Перелинковка';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionView($id, $selected_phrase_id = null)
    {
        $page = $this->loadPage($id);

        $this->render('view', compact('page'));
    }

    public function actionAdd()
    {
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));
        $page_from = $this->loadPage(Yii::app()->request->getPost('page_id'));
        $keyword_id = Yii::app()->request->getPost('keyword_id');

        $link = new InnerLink();
        $link->page_id = $page_from->id;
        $link->page_to_id = $phrase->page_id;
        $link->phrase_id = $phrase->id;
        $link->keyword_id = $keyword_id;

        echo CJSON::encode(array('status' => $link->save()));
    }

    public function actionPhraseInfo()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $parser = new SimilarArticlesParser;
        $phrase = $this->loadPhrase(Yii::app()->request->getPost('phrase_id'));
        $pages = $parser->getArticles($phrase->keyword->name);
        if (empty($pages)){
            //если яндекс не нашел статьи по запросу - выводим статьи из рубрики
            $url = $phrase->page->getRubricUrl();
            $pages = $parser->getArticles($url);
        }
        //удалим текущий
        foreach($pages as $key=>$page)
            if ($page->id == $phrase->page_id)
                unset($pages[$key]);

        $keywords = $phrase->getSimilarKeywords();

        $this->renderPartial('_phrase_view', compact('pages', 'keywords'));
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
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}