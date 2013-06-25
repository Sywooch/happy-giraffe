<?php

class DefaultController extends HController
{
    /**
     * @var User
     */
    public $user;
    public $rubric_id;
    public $layout = 'blog';
    public $tempLayout = true;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly - index, view',
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


    public function actionIndex($user_id, $rubric_id = null)
    {
        $this->user = $this->loadUser($user_id);
        $this->pageTitle = $this->user->getBlogTitle();
        $this->rubric_id = $rubric_id;

        $contents = BlogContent::model()->getBlogContents($user_id, $rubric_id);

        if ($this->user->hasRssContent())
            $this->rssFeed = $this->createUrl('rss/user', array('user_id' => $user_id));

        $this->render('list', array('contents' => $contents));
    }

    public function actionSubscribeToggle()
    {
        $blog_author_id = Yii::app()->request->getPost('user_id');

        echo CJSON::encode(array('status' => UserBlogSubscription::toggle($blog_author_id)));
    }

    public function getUrl($overwrite = array(), $route = '/blog/default/index')
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

    public function actionSettings()
    {
        $json = array(
            'title' => Yii::app()->user->model->blog_title,
            'description' => Yii::app()->user->model->blog_description,
        );

        $this->renderPartial('settings', compact('json'));
    }

    /**
     * @param int $id model id
     * @return User
     * @throws CHttpException
     */
    public function loadUser($id){
        $model = User::model()->with(array('blog_rubrics', 'avatar'))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}