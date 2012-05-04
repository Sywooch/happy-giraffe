<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class TaskController extends BController
{
    public $section = 'seo';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('seo'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        if (!Yii::app()->request->isAjaxRequest) {
            $basePath = Yii::app()->basePath . '\modules\seo\assets' . DIRECTORY_SEPARATOR;
            $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
            Yii::app()->clientScript->registerCoreScript('jquery')
                ->registerScriptFile($baseUrl . '/seo.js');
        }

        return true;
    }

    public function actionIndex()
    {
        $tasks = SeoTask::model()->findAllByAttributes(array('status' => SeoTask::STATUS_NEW));
        $this->render('index', array(
            'tasks' => $tasks
        ));
    }

    public function actionArticles()
    {
        $this->render('articles');
    }

    public function actionSearchKeywords()
    {
        $term = $_POST['term'];
        if (!empty($term)) {

            $allSearch = $textSearch = Yii::app()->search
                ->select('*')
                ->from('keywords')
                ->where('*' . $term . '*')
                ->limit(0, 1000)
                ->searchRaw();
            $ids = array();
            foreach ($allSearch['matches'] as $key => $m) {
                $ids [] = $key;
            }

            if (!empty($ids)) {
                $criteria = new CDbCriteria;
                $criteria->compare('id', $ids);
                //$criteria->with = array('keywordGroups', 'keywordGroups.newTaskCount', 'keywordGroups.articleKeywords');
                $models = Keywords::model()->findAll($criteria);
            }else
                $models = array();
            $this->renderPartial('_keywords', array('models' => $models));
        }
    }

    public function actionAddTask()
    {
        $key_id = Yii::app()->request->getPost('id');
        $key = Keywords::model()->findByPk($key_id);

        $group = new KeywordGroup();
        $group->keywords = array($key);
        if ($group->save()) {
            $task = new SeoTask();
            $task->keyword_group_id = $group->id;
            if ($task->save()) {
                $tasks = SeoTask::model()->findAllByAttributes(array('status' => SeoTask::STATUS_NEW));
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('_tasks', array('tasks' => $tasks), true)
                );
            }
            else
                $response = array('status' => false);
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionAddGroupTask()
    {
        $key_ids = Yii::app()->request->getPost('id');
        $keywords = Keywords::model()->findAllByPk($key_ids);

        $group = new KeywordGroup();
        $group->keywords = $keywords;
        if ($group->save()) {
            $task = new SeoTask();
            $task->keyword_group_id = $group->id;
            if ($task->save()) {
                $tasks = SeoTask::model()->findAllByAttributes(array('status' => SeoTask::STATUS_NEW));
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('_tasks', array('tasks' => $tasks), true)
                );
            }
            else
                $response = array('status' => false);
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionSetTask()
    {
        $id = Yii::app()->request->getPost('id');
        $type = Yii::app()->request->getPost('type');

        $task = SeoTask::model()->findByPk($id);
        if ($task !== null) {
            $task->type = $type;
            $this->status = self::STATUS_READY;
            if ($task->save()) {
                $response = array(
                    'status' => true,
                );
            } else {
                $response = array(
                    'status' => false,
                );
            }

            echo CJSON::encode($response);
        }
    }

    public function actionGetArticleInfo()
    {
        $url = Yii::app()->request->getPost('url');
        preg_match("/\/([\d]+)\/$/", $url, $match);
        $id = $match[1];
        if (strstr($url, '/community/')) {
            $article = CommunityContent::model()->findByPk($id);

            echo CJSON::encode(array(
                'title' => $article->meta_title,
                'keywords' => $article->meta_keywords,
                'id' => $article->id
            ));
        }
    }

    public function actionSaveArticleKeys()
    {
        $id = Yii::app()->request->getPost('id');
        $keywords = Yii::app()->request->getPost('keywords');

        $article = CommunityContent::model()->findByPk($id);
        $article_keywords = new ArticleKeywords();
        $article_keywords->entity = 'CommunityContent';
        $article_keywords->entity_id = $article->id;

        $group = new KeywordGroup();
        $keywords = array();

        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            if (!empty($keyword)) {
                $model = Keywords::model()->findByAttributes(array('name' => $keyword));
                if ($model === null)
                    throw new CHttpException(401, 'кейворд не найден в базе');
                $keywords[] = $model;
            }
        }

        if (empty($keywords))
            throw new CHttpException(401, 'нет ни одного кейворда');

        $group->keywords = $keywords;
        $group->save();

        $article_keywords->keyword_group_id = $group->id;

        if ($article_keywords->save()) {
            $response = array(
                'status' => true
            );
        } else {
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }
}
