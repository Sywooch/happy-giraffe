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
            //'ajaxOnly - index, view, upload, save',
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

        $this->rubric_id = ($content->type_id == 5) ? null : $content->rubric->id;

        if (!empty($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        //сохраняем просматриваемую модель
        NotificationRead::getInstance()->setContentModel($content);
        $this->render('view', array('data' => $content, 'full' => true));
    }

    public function actionRemove()
    {
        $id = Yii::app()->request->getPost('id');
        BlogContent::model()->findByPk($id)->delete();
        $success = true;
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRestore()
    {
        $id = Yii::app()->request->getPost('id');
        $success = BlogContent::model()->resetScope()->findByPk($id)->restore();
        $response = compact('success');
        echo CJSON::encode($response);
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

    public function actionForm($id = null, $type = null)
    {
        $this->user = $this->loadUser(Yii::app()->user->id);
        if ($id === null) {
            $model = new BlogContent();
            $model->type_id = $type;
            $slug = $model->type->slug;
            $slaveModelName = 'Community' . ucfirst($slug);
            $slaveModel = new $slaveModelName();
        } else {
            $model = BlogContent::model()->findByPk($id);
            $slaveModel = $model->getContent();
        }

        $json = array(
            'title' => (string)$model->title,
            'privacy' => (int)$model->privacy,
            'text' => (string)$slaveModel->text,
            'rubricsList' => array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                );
            }, $this->user->blog_rubrics),
        );
        if ($model->type_id == CommunityContent::TYPE_STATUS) {
            $json['moods'] = array_map(function ($mood) {
                return array(
                    'id' => (int)$mood->id,
                    'title' => (string)$mood->title,
                );
            }, UserMood::model()->findAll(array('order' => 'id ASC')));
            $json['mood_id'] = $slaveModel->mood_id;
        }
        if ($model->type_id == CommunityContent::TYPE_PHOTO_POST) {
            if ($model->isNewRecord)
                $json['photos'] = array();
            else
                $json['photos'] = $model->getContent()->getPhotoPostData();
            $json['albumsList'] = array_map(function ($album) {
                return array(
                    'id' => $album->id,
                    'title' => $album->title,
                );
            }, $this->user->simpleAlbums);
        }
        if ($model->type_id == CommunityContent::TYPE_VIDEO) {
            if ($model->isNewRecord) {
                $json['link'] = '';
                $json['embed'] = null;
            } else {
                $json['link'] = $model->video->link;
                $json['embed'] = $model->video->embed;
            }
        }

        if (Yii::app()->request->getPost('short'))
            $this->renderPartial('form/' . $model->type_id, compact('model', 'slaveModel', 'json'), false, true);
        else
            $this->renderPartial('form', compact('model', 'slaveModel', 'json'), false, true);
    }

    public function actionSave($id = null)
    {
        $model = ($id === null) ? new BlogContent() : BlogContent::model()->findByPk($id);
        $model->attributes = $_POST['BlogContent'];
        if ($model->type_id == CommunityContent::TYPE_STATUS)
            $model->scenario = 'status';
        if ($id === null)
            $model->author_id = Yii::app()->user->id;
        $slug = $model->type->slug;
        $slaveModelName = 'Community' . ucfirst($slug);
        $slaveModel = ($id === null) ? new $slaveModelName() : $model->content;
        $slaveModel->attributes = $_POST[$slaveModelName];
        $this->performAjaxValidation(array($model, $slaveModel));
        $model->$slug = $slaveModel;
        $success = $model->withRelated->save(true, array($slug));

        if ($success) {
            $this->redirect($model->url);
        } else {
            echo 'Root:<br />';
            var_dump($model->getErrors());
            echo 'Slave:<br />';
            var_dump($slaveModel->getErrors());
        }
    }

    public function actionVideoPreview($url)
    {
        $video = Video::factory($url);
        echo CJSON::encode($video->embed);
    }

    protected function performAjaxValidation($models)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-form') {
            echo CActiveForm::validate($models);
            Yii::app()->end();
        }
    }

    protected function getBlogData()
    {
        return array(
            'title' => $this->user->getBlogTitle(),
            'description' => $this->user->blog_description,
            'rubrics' => array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                    'url' => Yii::app()->createUrl('/blog/default/index', array('user_id' => $rubric->user_id, 'rubric_id' => $rubric->id)),
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

    public function actionCreateRubric()
    {
        $title = Yii::app()->request->getPost('title');
        $rubric = new CommunityRubric();
        $rubric->title = $title;
        $rubric->user_id = Yii::app()->user->id;
        $success = $rubric->save();
        $response = compact('success');
        if ($success)
            $response['id'] = $rubric->id;
        echo CJSON::encode($response);
    }

    public function actionCreateAlbum()
    {
        $title = Yii::app()->request->getPost('title');
        $album = new Album();
        $album->title = $title;
        $album->author_id = Yii::app()->user->id;
        $success = $album->save();
        $response = compact('success');
        if ($success)
            $response['id'] = $album->id;
        echo CJSON::encode($response);
    }

    public function actionRemoveRubric()
    {
        $id = Yii::app()->request->getPost('id');
        $rubric = CommunityRubric::model()->findByPk($id);
        if ($rubric->user_id == Yii::app()->user->id){
            $rubric->delete();
        }
        echo CJSON::encode(array('status' => true));
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