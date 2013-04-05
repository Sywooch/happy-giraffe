<?php

class DefaultController extends SController
{
    public $layout = 'best';

    public function beforeAction($action)
    {
        $this->pageTitle = 'лучшее';
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.image.*');

        return parent::beforeAction($action);
    }

	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionRemove(){
        $id = Yii::app()->request->getPost('id');
        $model = $this->loadModel($id);

        echo CJSON::encode(array('status' => $model->delete()));
    }

    /**
     * @param int $id model id
     * @return Product
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = Favourites::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}