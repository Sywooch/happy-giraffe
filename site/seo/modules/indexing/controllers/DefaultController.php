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
}