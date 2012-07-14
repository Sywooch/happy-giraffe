<?php

class DefaultController extends SController
{
    public $layout = '//layouts/indexing';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionGetUrls(){
        $plus = Yii::app()->request->getPost('plus');
        $up = $this->loadUp(Yii::app()->request->getPost('up_id'));
        $urls = $up->getUrls($plus);

        $this->renderPartial('_urls', array('urls'=>$urls));
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
}