<?php
/**
 * Author: choo
 * Date: 26.03.2012
 */
class BlogController extends HController
{
    public $user;
    public $rubric_id;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('list', 'view'),
                'users' => array('*'),
            ),
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function getUrl($overwrite = array(), $route = 'blog/list')
    {
        $params = array_filter(CMap::mergeArray(
            array(
                'user_id' => $this->user->id,
                'rubric_id' => isset($this->actionParams['rubric_id']) ? $this->actionParams['rubric_id'] : null,
                'content_type_slug' => isset($this->actionParams['content_type_slug']) ? $this->actionParams['content_type_slug'] : null,
            ),
            $overwrite
        ));

        return $this->createUrl($route, $params);
    }

    public function actionAdd($user_id = null, $content_type_slug = 'post', $rubric_id = null)
    {
        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug));
        $model = new BlogContent;
        $model->author_id = Yii::app()->user->id;
        $model->type_id = $content_type->id;
        $model->rubric_id = $rubric_id;
        $slave_model_name = 'Community' . ucfirst($content_type->slug);
        $slave_model = new $slave_model_name;
        $rubric_model = new CommunityRubric;

        $rubrics = Yii::app()->user->model->blog_rubrics;

        if (isset($_POST['BlogContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['BlogContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            if ($_POST['CommunityRubric']['title'] != '') {
                $rubric_model->user_id = Yii::app()->user->id;
                $rubric_model->title = $_POST['CommunityRubric']['title'];
                $rubric_model->save();
                $model->rubric_id = $rubric_model->id;
            }

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);
                $this->redirect($model->url);
            }
        }

        if (isset($_POST['redirectUrl']))
            $redirectUrl = $_POST['redirectUrl'];
        else
            $redirectUrl =Yii::app()->request->urlReferrer;

        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'rubric_model' => $rubric_model,
            'rubrics' => $rubrics,
            'content_type_slug' => $content_type->slug,
            'redirectUrl'=>$redirectUrl
        ));
    }

    public function actionEdit($content_id)
    {
        $model = BlogContent::model()->full()->findByPk($content_id);
        if ($model === null)
            throw CHttpException(404, 'Запись не найдена');

        $content_type = $model->type;
        $slave_model = $model->content;
        $slave_model_name = get_class($slave_model);
        $rubrics = $model->author->blog_rubrics;

        if (isset($_POST['BlogContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['BlogContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);
                $this->redirect($model->url);
            }
        }

        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'rubrics' => $rubrics,
            'content_type_slug' => $content_type->slug,
        ));
    }

    public function actionList($user_id, $rubric_id = null)
    {
        $this->layout = '//layouts/user_blog';
        $this->rssFeed = $this->createUrl('rss/user', array('user_id' => $user_id));

        $this->user = User::model()->findByPk($user_id);
        if ($this->user === null)
            throw new CHttpException(404, 'Пользователь не найден');
        $this->pageTitle = 'Блог';

        $contents = BlogContent::model()->getBlogContents($user_id, $rubric_id);

        $this->rubric_id = $rubric_id;

        $this->render('list', array(
            'contents' => $contents,
        ));
    }

    /**
     * @sitemap dataSource=getContentUrls
     */
    public function actionView($content_id, $user_id, $lastPage = null, $ajax = null)
    {
        $this->layout = '//layouts/user_blog';

        $content = BlogContent::model()->active()->full()->findByPk($content_id);
        if ($content === null)
            throw new CHttpException(404, 'Такой записи не существует');

        if (! preg_match('#^\/user\/(\d+)\/blog\/post(\d+)\/#', Yii::app()->request->requestUri)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        $this->pageTitle = $content->title;

        $this->user = $content->author;
        $this->rubric_id = $content->rubric->id;

        if ($content->author_id == Yii::app()->user->id) {
            UserNotification::model()->deleteByEntity(UserNotification::NEW_COMMENT, $content);
            UserNotification::model()->deleteByEntity(UserNotification::NEW_REPLY, $content);
        }

        $this->render('view', array(
            'data' => $content,
        ));
        //
    }

    public function actionEmpty()
    {
        $this->layout = '//layouts/user';

        $this->user = Yii::app()->user->model;
        $this->render('empty');
    }

    public function getContentUrls()
    {
        $models = Yii::app()->db->createCommand()
            ->select('c.id, c.created, c.updated, c.author_id')
            ->from('community__contents c')
            ->join('community__rubrics r', 'c.rubric_id = r.id')
            ->join('community__content_types ct', 'c.type_id = ct.id')
            ->where('r.user_id IS NOT NULL AND c.removed = 0')
            ->queryAll();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'content_id' => $model['id'],
                    'user_id' => $model['author_id'],
                ),
                'priority' => 0.5,
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }
        return $data;
    }
}
