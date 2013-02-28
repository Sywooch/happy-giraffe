<?php
/**
 * Author: alexk984
 * Date: 23.08.12
 */
class CommentatorController extends HController
{
    public $layout = 'commentator';
    /**
     * @var User
     */
    public $user;
    /**
     * @var CommentatorWork
     */
    public $commentator;

    public function filters()
    {
        return array(
            'ajaxOnly + blog, club, comments',
        );
    }

    protected function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('commentator_panel') && !Yii::app()->user->checkAccess('administrator'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.frontend.modules.cook.components.*');
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.models.mongo.*');
        Yii::import('site.seo.modules.writing.models.*');

        $this->user = Yii::app()->user->model;
        $this->commentator = CommentatorWork::getCurrentUser();
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (!$this->commentator->IsWorksToday(Yii::app()->user->id))
            $this->redirect('/commentator/statistic');

        $this->render('index');
    }

    public function actionStatistic($period = null)
    {
        if (empty($period))
            $period = date("Y-m");
        $this->render('statistic', compact('period'));
    }

    public function actionHelp()
    {
        $this->render('help');
    }

    public function actionIAmWorking()
    {
        $this->commentator->WorksToday(Yii::app()->user->id);
        $this->redirect($this->createUrl('/signal/commentator/index'));
    }

    public function actionUsers()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = array('active');
        $criteria->order = 't.id desc';
        $criteria->condition = 't.id != :me AND t.id NOT IN (
                SELECT to_id FROM friend_requests WHERE from_id = :me
                UNION
                SELECT from_id FROM friend_requests WHERE to_id = :me
            )';
        $criteria->params = array(':me' => Yii::app()->user->id);

        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 12),
            'totalItemCount' => 10000
        ));

        $this->render('new_users', compact('dataProvider'));
    }

    public function actionPopular()
    {
        $this->render('how_to_be_popular');
    }

    /**
     * блоги
     */
    public function actionBlog()
    {
        $this->renderPartial('_blog_posts', array('blog_posts' => $this->commentator->blogPosts()));
    }

    /**
     * клубы
     */
    public function actionClub()
    {
        $this->renderPartial('_club_posts', array('club_posts' => $this->commentator->clubPosts()));
    }

    /**
     * комментарии
     */
    public function actionComments()
    {
        $this->renderPartial('_comments');
    }

    /**
     * Пропустить комментарий
     */
    public function actionSkip()
    {
        $res = $this->commentator->skipComment();

        if ($res) {
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_comments', array(), true)
            );
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    /**
     * Взять подсказку
     */
    public function actionTake()
    {
        Yii::app()->end();

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $task = $this->loadModel(Yii::app()->request->getPost('id'));
            $block = Yii::app()->request->getPost('block');

            if ($task->status != SeoTask::STATUS_READY) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Кейворд уже взят другим пользователем'
                ));
                Yii::app()->end();
            }

            $task->executor_id = Yii::app()->user->id;
            $task->multivarka = $block;
            $task->status = SeoTask::STATUS_TAKEN;
            echo CJSON::encode(array('status' => $task->save()));

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            echo CJSON::encode(array('status' => false, 'error' => $e->getMessage()));
        }
    }

    /**
     * Отказаться от подсказки
     */
    public function actionCancelTask()
    {
        $task = $this->loadModel(Yii::app()->request->getPost('id'));
        if ($task->executor_id == Yii::app()->user->id) {
            $task->executor_id = null;
            $task->multivarka = null;
            $task->status = SeoTask::STATUS_READY;
            echo CJSON::encode(array('status' => $task->save()));
        }
    }

    /**
     * Статья по подсказке написана
     */
    public function actionExecuted()
    {
        $task = $this->loadModel(Yii::app()->request->getPost('id'));
        $url = Yii::app()->request->getPost('url');

        if ($task->executor_id != Yii::app()->user->id || empty($url))
            Yii::app()->end();

        $keywords = array();
        foreach ($task->keywordGroup->keywords as $keyword)
            $keywords [] = $keyword->id;

        $page = Page::model()->getOrCreate($url, $keywords, true);
        if ($page) {
            $task->status = SeoTask::STATUS_CLOSED;
            $task->article_id = $page->id;
            $task->article_title = $page->getArticleTitle();
            echo CJSON::encode(array('status' => $task->save()));
            CommentatorWork::getCurrentUser()->refreshCurrentDayPosts();
        } else {
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Статья не найдена'
            ));
        }
    }

    public function actionTasks()
    {
        $tasks = SeoTask::getCommentatorTasks();
        $this->renderPartial('tasks', compact('tasks'));
    }

    public function actionCancelTaskAdmin($id){
        if (!Yii::app()->user->checkAccess('administrator'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $task = $this->loadModel($id);
        $task->executor_id = null;
        $task->multivarka = null;
        $task->article_id = null;
        $task->article_title = null;
        $task->status = SeoTask::STATUS_READY;
        echo $task->save();
    }

    /**
     * @param int $id model id
     * @return SeoTask
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SeoTask::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
