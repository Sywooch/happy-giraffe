<?php

class DefaultController extends SController
{
    public $layout = 'best';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('best_module'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'лучшее';
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.extensions.image.*');

        return parent::beforeAction($action);
    }

    /**
     * Самое интересное
     */
    public function actionIndex()
	{
		$this->render('index');
	}

    /**
     * В блоги
     */
    public function actionBlogs()
    {
        $this->render('blogs');
    }

    /**
     * В соц сети
     */
    public function actionSocial()
    {
        $this->render('social');
    }

    /**
     * В соц сети
     */
    public function actionEmail()
    {
        $this->render('email');
    }

    /**
     * Удаление из избранного
     */
    public function actionRemove(){
        $id = Yii::app()->request->getPost('id');
        $model = $this->loadModel($id);

        echo CJSON::encode(array('status' => $model->delete()));
    }

    /**
     * Перемещение эл-та избранного
     */
    public function actionNewPos(){
        $id = Yii::app()->request->getPost('id');
        $date = Yii::app()->request->getPost('date');
        $index = Yii::app()->request->getPost('index');
        $model = $this->loadModel($id);
        $model->changePosition($date, $index);

        echo CJSON::encode(array('status' => true));
    }

    /**
     * @param int $id model id
     * @return Favourites
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = Favourites::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}