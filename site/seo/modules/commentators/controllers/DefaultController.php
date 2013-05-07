<?php

class DefaultController extends SController
{
    public $layout = '/layout/commentators';
    public $icon = 2;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('commentator-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.frontend.modules.signal.components.*');
        Yii::import('site.frontend.modules.signal.helpers.*');
        Yii::import('site.frontend.modules.im.models.*');

        $this->pageTitle = 'комментаторы';
        return parent::beforeAction($action);
    }

    public function actionIndex($month = null)
    {
        if (empty($month))
            $month = date("Y-m");

        $this->render('tasks', compact('month'));
    }

    public function actionAward($month = null)
    {
        if (empty($month))
            $month = date("Y-m");

        $this->render('awards', compact('month'));
    }

    public function actionLinks($user_id = null, $month = null)
    {
        if (empty($month))
            $month = date("Y-m");

        if (empty($user_id))
            $this->render('links_all', compact('month'));
        else {
            $this->addEntityToFastList('commentators', $user_id, 3);
            $commentator = CommentatorWork::getUser($user_id);
            $this->render('links', compact('month', 'commentator'));
        }
    }

    public function actionReports($user_id = null, $month = null)
    {
        if (empty($month))
            $month = date("Y-m");

        if (empty($user_id))
            $this->render('reports_all', compact('month'));
        else {
            $this->addEntityToFastList('commentators', $user_id, 3);
            $commentator = CommentatorWork::getUser($user_id);
            $this->render('reports', compact('month', 'commentator'));
        }
    }

    public function actionPause()
    {
        $task = $this->loadTask(Yii::app()->request->getPost('id'));
        $task->toggleStatus();
        echo CJSON::encode(array('status' => $task->save()));
    }

    public function actionAddTask()
    {
        $task = new CommentatorTask;
        $task->page_id = Yii::app()->request->getPost('page_id');
        $task->type = Yii::app()->request->getPost('type');
        if ($task->save()) {
            $response = array(
                'status' => true,
                'date' => Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($task->created)),
                'data' => $task->getViewModel()
            );
        } else
            $response = array('status' => false, 'error'=>$task->getErrors());

        echo CJSON::encode($response);
    }

    public function actionLoadPage()
    {
        $url = Yii::app()->request->getPost('url');
        $page = Page::getPage($url);

        if ($page !== null) {
            $article = $page->getArticle();

            echo CJSON::encode(array(
                'status' => true,
                'page_id' => $page->id,
                'article_url' => $article->url,
                'article_title' => $article->title,
            ));
        } else
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Не найдена страницу, обратитесь к разработчикам'
            ));
    }

    /**
     * @param int $id model id
     * @return CommentatorTask
     * @throws CHttpException
     */
    public function loadTask($id)
    {
        $model = CommentatorTask::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}