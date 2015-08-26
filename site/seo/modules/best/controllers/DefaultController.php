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

    public function actionSend()
    {
        $subject = Yii::app()->request->getPost('subject', null);
        $real = Yii::app()->request->getPost('real', false);

        $lastSend = Yii::app()->getGlobalState('lastSend', 0);
        if (($lastSend < (time() - 3600 * 20)) && $real) {
            echo CJSON::encode(array('success' => false, 'error' => 'Сегодня уже отправляли'));
            Yii::app()->end();
        }

        if (empty($subject)) {
            echo CJSON::encode(array('success' => false, 'error' => 'Тема письма не может быть пустой'));
            Yii::app()->end();
        }

        $date = date('Y-m-d');
        $articles = Favourites::model()->getWeekPosts($date);
        if (count($articles) != 6) {
            echo CJSON::encode(array('success' => false, 'error' => 'Отмечено менее 6 постов'));
            Yii::app()->end();
        }
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);
        if ($real) {
            ElasticEmail::sendCampaign($contents, null, 'clicked', 'weekly_news', $subject);
        } else {
            ElasticEmail::sendCampaign($contents, HEmailSender::LIST_TEST_LIST, null, 'weekly_news', $subject);
        }
        echo CJSON::encode(array('success' => true));

        if ($real) {
            Yii::app()->setGlobalState('lastSend', time());
        }
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