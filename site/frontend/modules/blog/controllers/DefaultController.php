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
            'ajaxOnly - index, view, upload',
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

    public function actionView($content_id, $user_id)
    {
        $this->user = $this->loadUser($user_id);
        $content = $this->loadPost($content_id);

        if (!preg_match('#^\/user\/(\d+)\/blog\/post(\d+)\/#', Yii::app()->request->requestUri)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        if ($content->type_id == CommunityContentType::TYPE_STATUS)
            $this->pageTitle = strip_tags($content->status->text);
        else
            $this->pageTitle = $content->title;
        $this->registerCounter();

        $this->rubric_id = ($content->type_id == 5) ? null : $content->rubric->id;

        if (!empty($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        //сохраняем просматриваемую модель
        NotificationRead::getInstance()->setContentModel($content);
        $this->render('view', array('data' => $content, 'full' => true));
    }

    public function actionUpload()
    {
        $this->user = $this->loadUser(Yii::app()->user->id);
        $this->render('upload');
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

    public function actionAttachBlog()
    {
        $this->user = Yii::app()->user->model;
        $content = $this->loadPost(Yii::app()->request->getPost('id'));
        if ($content->author_id == Yii::app()->user->id && $content->getIsFromBlog()) {
            echo CJSON::encode(array('status' => $content->attachBlogPost()));
        }
    }

    public function actionUpdatePrivacy()
    {
        $this->user = Yii::app()->user->model;
        $content = $this->loadPost(Yii::app()->request->getPost('id'));
        if ($content->author_id == Yii::app()->user->id && $content->getIsFromBlog()) {
            $content->privacy = Yii::app()->request->getPost('privacy');
            echo CJSON::encode(array('status' => $content->update(array('privacy'))));
        }
    }

    public function actionForm($type)
    {
        $this->user = $this->loadUser(Yii::app()->user->id);
        $contentType = CommunityContentType::model()->findByPk($type);
        $model = new CommunityContent();
        $model->type_id = $type;
        $slaveModelName = 'Community' . ucfirst($contentType->slug);
        $slaveModel = new $slaveModelName();
        $this->renderPartial('form', compact('model', 'slaveModel', 'type'));
    }

    protected function getBlogData()
    {
        return array(
            'title' => $this->user->getBlogTitle(),
            'description' => $this->user->blog_description,
            'rubrics' => array_map(function($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                    'url' => Yii::app()->createUrl('index', array('user_id' => $rubric->user_id, 'rubric_id' => $rubric->id)),
                );
            }, $this->user->blog_rubrics),
            'currentRubricId' => $this->rubric_id,
            'updateUrl' => $this->createUrl('settings/update'),
            'photo' => array(
                'id' => $this->user->blogPhoto === null ? null : $this->user->blogPhoto->id,
                'originalSrc' => $this->user->getBlogPhotoOriginal(),
                'thumbSrc' => $this->user->getBlogPhotoThumb(),
                'width' => $this->user->getBlogPhotoWidth(),
                'height' => $this->user->getBlogPhotoHeight(),
                'position' => $this->user->getBlogPhotoPosition(),
            ),
        );
    }

    /**
     * @param int $id model id
     * @return BlogContent
     * @throws CHttpException
     */
    public function loadPost($id)
    {
        $model = BlogContent::model()->active()->with(array('rubric', 'type', 'gallery'))->findByPk($id);
        if ($model === null || $model->author_id !== $this->user->id)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        return $model;
    }

    /**
     * @param int $id model id
     * @return User
     * @throws CHttpException
     */
    public function loadUser($id)
    {
        $model = User::model()->with(array('blog_rubrics', 'avatar'))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}