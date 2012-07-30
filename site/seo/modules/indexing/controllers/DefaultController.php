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
        $model = IndexingUp::model()->with(array(
            'urls',
            'urls.url'=>array(
                'order'=>'url.url'
            )))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionTest(){
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $content = <<<EOD
EOD;
        $document = phpQuery::newDocument($content);

        $el = $document->find('div.b-bottom-wizard div.b-pager span.b-pager__arrow:eq(1)');
        if (pq($el)->hasClass('b-pager__inactive'))
            echo 1;
        else
            echo 0;
    }
}