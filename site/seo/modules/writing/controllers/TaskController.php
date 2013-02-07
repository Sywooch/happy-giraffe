<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class TaskController extends SController
{
    public function actionExecuted()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status != SeoTask::STATUS_TAKEN && $task->status != SeoTask::STATUS_PUBLICATION)
            Yii::app()->end();

        $url = trim(Yii::app()->request->getPost('url'));

        $page = Page::model()->findByAttributes(array('url' => $url));
        if ($page !== null) {
            $page->keyword_group_id = $task->keyword_group_id;

            $article = CommunityContent::model()->findByPk($page->entity_id);

            if ($article === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            if (!$page->save()) {
                $errorText = '';
                foreach ($page->getErrors() as $error) {
                    foreach ($error as $errorPart)
                        $errorText .= $errorPart . ' ';
                }

                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка сохранения статьи',
                    'errorText' => $errorText
                ));
                Yii::app()->end();
            }
        } elseif (!empty($url)) {
            preg_match("/([\d]+)\/$/", $url, $match);
            if (!isset($match[1])) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            $article_id = $match[1];
            $article = CommunityContent::model()->findByPk($article_id);
            if ($article === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            $page = new Page();
            if ($article->getIsFromBlog())
                $page->entity = 'BlogContent';
            else
                $page->entity = 'CommunityContent';
            $page->entity_id = $article_id;
            $page->keyword_group_id = $task->keyword_group_id;
            $page->url = $url;
            if (!$page->save()) {
                $errorText = '';
                foreach ($page->getErrors() as $error) {
                    foreach ($error as $errorPart)
                        $errorText .= $errorPart . ' ';
                }

                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка сохранения статьи',
                    'errorText' => $errorText
                ));
                Yii::app()->end();
            }
        } else {
            if ($task->type == SeoTask::TYPE_EDITOR){
                $task->status = SeoTask::STATUS_WRITTEN;
                echo CJSON::encode(array('status' => $task->save()));
                Yii::app()->end();
            }
            else {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Не ввели url статьи'
                ));
                Yii::app()->end();
            }
        }

        if (isset($article)) {
            $task->article_id = $page->id;
            if (empty($task->article_title))
                $task->article_title = $article->title;
        }

        $task->status = SeoTask::STATUS_PUBLISHED;

        echo CJSON::encode(array('status' => $task->save()));
    }

    public function actionTake()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status != SeoTask::STATUS_READY) {
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'задание уже забито'
            ));
            Yii::app()->end();
        }

        $task->executor_id = Yii::app()->user->id;
        $task->status = SeoTask::STATUS_TAKEN;
        if ($task->save()) {
            echo CJSON::encode(array('status' => true));

            if ($task->type == SeoTask::TYPE_MODER) {
                $comet = new CometModel();
                $comet->type = CometModel::SEO_TASK_TAKEN;
                $comet->attributes = array('task_id' => $task->id);
                $comet->sendToSeoUsers();
            }
        } else
            echo CJSON::encode(array('status' => false));
    }


    public function actionRollBackTask($id){
        $task = $this->loadTask($id);
        $task->article_id = null;
        $task->article_title = null;
        $task->status = SeoTask::STATUS_TAKEN;
        $task->save();
    }

    /**
     * @param int $id model id
     * @return SeoTask
     * @throws CHttpException
     */
    public function loadTask($id)
    {
        $model = SeoTask::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
