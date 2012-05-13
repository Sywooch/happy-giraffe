<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class TaskController extends SController
{
    public function actionIndex()
    {
        $model = new Keywords('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Keywords']))
            $model->attributes = $_GET['Keywords'];
        if (empty($model->name))
            $model->name = 'поисковый запрос';

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionTasks(){
        $tasks = SeoTask::model()->findAllByAttributes(array('status' => SeoTask::STATUS_NEW));
        $tempKeywords = TempKeywords::model()->findAll('owner_id');
        $this->render('index', array(
            'tasks' => $tasks,
            'tempKeywords'=>$tempKeywords
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

    public function actionSelectKeyword(){
        $key_id = Yii::app()->request->getPost('id');
        $temp = new TempKeywords;
        $temp->keyword_id = $key_id;
        $temp->owner_id = Yii::app()->user->id;
        echo CJSON::encode(array('status' => $temp->save()));
    }

    public function actionAddGroupTask()
    {
        $key_ids = Yii::app()->request->getPost('id');
        $type = Yii::app()->request->getPost('type');
        $keywords = Keywords::model()->findAllByPk($key_ids);

        $group = new KeywordGroup();
        $group->keywords = $keywords;
        if ($group->save()) {
            $task = new SeoTask();
            $task->keyword_group_id = $group->id;
            $task->type = $type;
            $task->status = SeoTask::STATUS_READY;
            $response = array('status' => $task->save());
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionGetArticleInfo()
    {
        $url = Yii::app()->request->getPost('url');
        preg_match("/\/([\d]+)\/$/", $url, $match);
        $id = $match[1];

        if (strstr($url, '/community/')) {
            $article = CommunityContent::model()->findByPk($id);
            if (!$article){
                echo CJSON::encode(array(
                    'status'=>false,
                    'error'=>'Ошибка, статья не найдена'
                ));
                Yii::app()->end();
            }

            echo CJSON::encode(array(
                'status'=>true,
                'title' => $article->title,
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
