<?php

class DefaultController extends SController
{
    public $layout = '//layouts/indexing';
    public $pageTitle = 'ИНДЕКСАЦИЯ';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex($up_id = null)
    {
        if (empty($up_id))
            $up = IndexingUp::model()->find();
        else
            $up = $this->loadUp($up_id);

        $this->render('index', compact('up'));
    }

    /**
     * @param int $id model id
     * @return IndexingUp
     * @throws CHttpException
     */
    public function loadUp($id){
        $model = IndexingUp::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionDeleteCache($id)
    {
        Yii::app()->cache->delete('indexation-'.$id);
    }

    public function actionTest(){
        /*$parser = new IndexParserThread;
        $parser->debug = true;
        $parser->up_id = 45;
        $parser->use_proxy = false;
        $parser->url = IndexingUrl::model()->findByPk(42270);
        $parser->parsePage();*/

        $urlCollector = new UrlCollector;
        $urlCollector->collectCookRecipes();
    }
}