<?php
/**
 * Author: alexk984
 * Date: 23.08.12
 */
class CommentatorController extends CController
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
            'accessControl',
            'ajaxOnly + emptyTasks, skip, take, cancelTask, executed, setSort, deleteLink',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
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
        Yii::import('site.seo.modules.commentators.models.*');

        $this->user = Yii::app()->user->model;
        $this->commentator = CommentatorWork::getCurrentUser();

        return parent::beforeAction($action);
    }

    /**
     * Страница "задачи"
     */
    public function actionIndex()
    {
        if (!$this->commentator->IsWorksToday())
            $this->commentator->CreateWorkingDay();

        $this->render('tasks/index');
    }

    /**
     * Страница "ссылки"
     */
    public function actionLinks($month = null)
    {
        if (empty($month))
            $month = date("Y-m");
        $links = $this->commentator->GetLinks($month);
        $this->render('links', compact('links', 'month'));
    }

    /**
     * Страница "отчеты"
     * @param string $section раздел отчетности
     * @param string $month
     */
    public function actionReports($section = null, $month = null)
    {
        if (empty($section))
            $section = 'plan';
        if (empty($month))
            $month = date("Y-m");

        $this->render('reports/report', compact('month', 'section'));
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
            ) AND t.deleted = 0';
        $criteria->params = array(':me' => Yii::app()->user->id);

        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 12),
            'totalItemCount' => 50
        ));

        $this->render('users/new_users', compact('dataProvider'));
    }

    public function actionSecrets()
    {
        $this->render('secrets');
    }


    public function actionEmptyTasks()
    {
        $task = CommentatorWork::getTasksView(SeoTask::getCommentatorTasks());
        echo CJSON::encode($task);
    }

    /**
     * Пропустить комментарий
     */
    public function actionSkip()
    {
        if ($this->commentator->skipComment()) {
            $model = $this->commentator->getNextComment();
            $response = array(
                'status' => true,
                'url' => $model->url,
                'title' => $model->title
            );
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionAward($month = null)
    {
        $type = 'me';
        if (empty($month))
            $month = date("Y-m");
        $this->render('award/' . $type, compact('month'));
    }

    public function actionTeam($month = null, $user_id = null)
    {
        if (empty($month))
            $month = date("Y-m");

        if (empty($user_id))
            $this->render('team', compact('month'));
        else {
            $this->addEntityToFastList('commentators', $user_id, 3);
            $commentator = CommentatorWork::getUser($user_id);
            $this->render('team_one', compact('month', 'commentator'));
        }
    }

    /**
     * Взять подсказку
     */
    public function actionTake()
    {
        $block = Yii::app()->request->getPost('block');

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $task = $this->loadModel(Yii::app()->request->getPost('id'));
            if ($task->status != SeoTask::STATUS_READY) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Кейворд уже взят другим пользователем'
                ));
                Yii::app()->end();
            }

            $task->executor_id = Yii::app()->user->id;
            $task->sub_section = $block;
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
            $task->sub_section = 0;
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

        if ($task->executor_id != Yii::app()->user->id || empty($url) || $task->status == SeoTask::STATUS_CLOSED)
            Yii::app()->end();

        $keywords = array();
        foreach ($task->keywordGroup->keywords as $keyword)
            $keywords [] = $keyword->id;

        $page = Page::model()->getOrCreate($url, $keywords, true);
        if ($page == null || $page->getArticle() === null) {
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Статья не найдена'
            ));
        } else {
            $article = $page->getArticle();
            if ($article->author_id == Yii::app()->user->id) {
                $task->status = SeoTask::STATUS_CLOSED;
                $task->article_id = $page->id;
                $task->article_title = $page->getArticleTitle();
                if ($task->save()) {
                    $day = $this->commentator->getCurrentDay();
                    if ($task->sub_section == 0)
                        $day->blog_posts++;
                    else
                        $day->club_posts++;
                    $day->updatePosts($this->commentator);

                    echo CJSON::encode(array(
                        'status' => true,
                        'article_title' => $task->article_title
                    ));
                } else {
                    echo CJSON::encode(array(
                        'status' => false,
                        'error' => $task->getErrors()
                    ));
                }
            } else {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Не вы написали эту статью'
                ));
            }
        }
    }

    /**
     * Добавление новой ссылки
     */
    public function actionAddLink()
    {
        $url = Yii::app()->request->getPost('url');
        $page_url = Yii::app()->request->getPost('page_url');

        list($entity, $entity_id) = Page::ParseUrl($page_url);

        if (empty($entity) || empty($entity_id)) {
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Неправильный url',
            ));
        } else {
            $article = CActiveRecord::model($entity)->findByPk($entity_id);
            if ($article === null)
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена',
                ));
            else {
                $model = new CommentatorLink();
                $model->entity = $entity;
                $model->entity_id = $entity_id;
                $model->url = $url;
                $model->user_id = Yii::app()->user->id;
                if ($model->save()) {
                    $response = array(
                        'status' => true,
                        'html' => $this->renderPartial('_link', array('link' => $model, 'count' => 1), true)
                    );
                } else
                    $response = array('status' => false, 'error' => $model->getErrorsText());

                echo CJSON::encode($response);
            }
        }
    }

    public function actionSetSort()
    {
        UserAttributes::set(Yii::app()->user->id, 'commentators_se_visits_sort', Yii::app()->request->getPost('sort'));
    }

    public function actionDeleteLink()
    {
        $link = $this->loadLink(Yii::app()->request->getPost('id'));
        if ($link->user_id == Yii::app()->user->id)
            echo CJSON::encode(array('status' => $link->delete()));
    }

    public function actionCancelTaskAdmin($id)
    {
        if (!Yii::app()->user->checkAccess('administrator'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $task = $this->loadModel($id);
        $task->executor_id = null;
        $task->sub_section = 0;
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

    /**
     * @param int $id model id
     * @return CommentatorLink
     * @throws CHttpException
     */
    public function loadLink($id)
    {
        $model = CommentatorLink::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function addEntityToFastList($list_name, $entity_id, $limit = null)
    {
        $entities = Yii::app()->user->getState($list_name);
        if (!is_array($entities))
            $entities = array($entity_id);
        elseif (!in_array($entity_id, $entities))
            $entities[] = $entity_id;
        if (!empty($limit) && count($entities) > $limit)
            array_shift($entities);
        Yii::app()->user->setState($list_name, $entities);
    }
}
