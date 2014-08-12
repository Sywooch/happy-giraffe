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

    public function behaviors()
    {
        return array(
            'lastModified' => array(
                'class' => 'LastModifiedBehavior',
                'getParameter' => 'content_id',
                'entity' => 'BlogContent',
            ),
        );
    }

    public function filters()
    {
        $filters = array(
            'accessControl',
           // 'ajaxOnly - index, view, save, live',
        );

        if (Yii::app()->user->isGuest) {
            $filters[] = array(
                'CHttpCacheFilter + view',
                'lastModified' => $this->lastModified->getDateTime(),
            );

            $filters [] = array(
                'COutputCache + view',
                'duration' => 300,
                'varyByParam' => array('content_id', 'openGallery'),
            );

            $filters [] = array(
                'COutputCache + index',
                'duration' => 300,
                'varyByParam' => array('user_id', 'rubric_id', 'BlogContent_page'),
            );
        }

        return $filters;
    }

    public function accessRules()
    {
        return array(
            array(
                'deny',
                'actions' => array('save', 'remove', 'restore', 'subscribeToggle', 'form'),
                'users' => array('?'),
            ),

        );
    }

    protected function afterAction($action)
    {
        if (Yii::app()->user->isGuest && $this->user) {
            $clubs = Yii::app()->user->getState('visitedBlogs', array());
            if (array_search($this->user->id, $clubs) === false) {
                $clubs[] = $this->user->id;
                Yii::app()->user->setState('visitedBlogs', $clubs);
            }
        }
    }

    /**
     * @sitemap dataSource=sitemapUser
     */
    public function actionIndex($user_id, $rubric_id = null)
    {
        if ($user_id == User::HAPPY_GIRAFFE)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->user = $this->loadUser($user_id);
        $this->pageTitle = $this->user->getBlogTitle();
        $this->rubric_id = $rubric_id;

        $contents = BlogContent::model()->getBlogContents($user_id, $rubric_id);

        NoindexHelper::setNoIndex($this->user);

        if ($this->user->hasRssContent())
            $this->rssFeed = $this->createUrl('/rss/user', array('user_id' => $user_id));

        if (! Yii::app()->user->isGuest)
            $this->breadcrumbs['Люди на сайте'] = $this->createUrl('/friends/search/index');
        $this->breadcrumbs[$this->user->getFullName()] = $this->user->getUrl();
        if ($rubric_id !== null) {
            $rubric = CommunityRubric::model()->findByPk($rubric_id);
            if ($rubric === null)
                throw new CHttpException(404);

            $this->breadcrumbs += array(
                'Блог' => $this->user->getBlogUrl(),
                $rubric->title,
            );
        } else
            $this->breadcrumbs[] = 'Блог';

        $this->render('list', array('contents' => $contents));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($content_id, $user_id)
    {
        header('X-XSS-Protection: 0');
        if ($user_id == User::HAPPY_GIRAFFE)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->user = $this->loadUser($user_id);
        $content = $this->loadPost($content_id);
        if ($content->type_id == 1)
            $content->getContent()->forEdit->text;

        if (!preg_match('#^\/user\/(\d+)\/blog\/post(\d+)\/#', Yii::app()->request->requestUri)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        if ($content->type_id == CommunityContentType::TYPE_STATUS)
            $this->pageTitle = $content->author->getFullName() . ' - статус от ' . Yii::app()->dateFormatter->format('dd.MM.yy hh:mm', $content->created);
        else
            $this->pageTitle = $content->title;

        $this->rubric_id = $content->rubric->id;

        NoindexHelper::setNoIndex($content);

        if (! Yii::app()->user->isGuest)
            $this->breadcrumbs['Люди на сайте'] = $this->createUrl('/friends/search/index');
        $this->breadcrumbs += array(
            $this->user->getFullName() => $this->user->getUrl(),
            'Блог' => $this->user->getBlogUrl(),
            $content->rubric->title => $content->rubric->getUrl(),
            $content->title,
        );

        // Поставим флаг, что бы для найденных сущностей прочитались сигналы
        \site\frontend\modules\notifications\behaviors\ContentBehavior::$active = true;
        
        if (Yii::app()->user->isGuest)
            $this->render('view_requirejs', array('data' => $content, 'full' => true));
        else
        $this->render('view', array('data' => $content, 'full' => true));
    }

    public function actionRemove()
    {
        $id = Yii::app()->request->getPost('id');
        $post = BlogContent::model()->findByPk($id);
        if (! $post->canEdit())
            throw new CHttpException(403);

        $post->delete();
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
        if ($blog_author_id == Yii::app()->user->id)
            return ;

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

    public function actionForm($id = null, $type = null, $club_id = false, $contest_id = null)
    {
        $this->user = $this->loadUser(Yii::app()->user->id);
        if ($id === null) {
            if ($club_id)
                $model = new CommunityContent('default_club');
            else
                $model = new BlogContent('default');
            $model->type_id = $type;
            $slug = $model->type->slug;
            $slaveModelName = 'Community' . ucfirst($slug);
            $slaveModel = new $slaveModelName();
        } else {
            if ($club_id)
                $model = CommunityContent::model()->findByPk($id);
            else
                $model = BlogContent::model()->findByPk($id);
            $slaveModel = $model->getContent();
        }

        if (!$model->isNewRecord && !$model->canEdit())
            Yii::app()->end();

        if ($club_id){
            $rubricsList = array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                );
            }, Community::model()->findByPk($club_id)->rubrics);
        }else{
            $rubricsList = array_map(function ($rubric) {
                return array(
                    'id' => $rubric->id,
                    'title' => $rubric->title,
                );
            }, $this->user->blog_rubrics);
        }

        $json = array(
            'title' => (string)$model->title,
            'privacy' => (int)$model->privacy,
            'text' => (string)$slaveModel->text,
            'rubricsList' => $rubricsList,
            'selectedRubric' => $id === null ? null : $model->rubric_id,
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

        if ($contest_id !== null) {
            Yii::import('application.modules.community.models.*');
            $contest = CommunityContest::model()->with('forum')->findByPk($contest_id);
            $model->rubric_id = $contest->rubric_id;
            $this->renderPartial('form/contest/' . $contest->id, compact('model', 'slaveModel', 'json', 'club_id', 'contest_id', 'contest'), false, true);
        }
        elseif (Yii::app()->request->getPost('short'))
            $this->renderPartial('form/' . $model->type_id, compact('model', 'slaveModel', 'json', 'club_id'), false, true);
        else
            $this->renderPartial('form', compact('model', 'slaveModel', 'json', 'club_id'), false, true);
    }

    public function actionSave($id = null)
    {
        $model = ($id === null) ? new BlogContent() : BlogContent::model()->findByPk($id);
        if (! $model->isNewRecord && ! $model->canEdit())
            throw new CHttpException(403);
        $model->scenario = 'default';
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
            if (isset($_POST['redirect']))
                $this->redirect($_POST['redirect']);
            else
                $this->redirect($model->url);
        } else {
            echo 'Root:<br />';
            var_dump($model->getErrors());
            echo 'Slave:<br />';
            var_dump($slaveModel->getErrors());
        }
    }

    public function actionVideoPreview($url, $width = 580)
    {
        try {
            $video = Video::factory($url);
            $response = array(
                'success' => true,
                'html' => $video->getEmbed($width),
            );
        }
        catch (CException $e) {
            $response = array(
                'success' => false,
            );
        }

        echo CJSON::encode($response);
    }

    protected function performAjaxValidation($models)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-form') {
            echo CActiveForm::validate($models);
            Yii::app()->end();
        }
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
        if ($rubric->user_id == Yii::app()->user->id) {
            $rubric->delete();
        }
        echo CJSON::encode(array('status' => true));
    }

    public function actionRubricsList($userId, $currentRubricId = null)
    {
        $this->user = $this->loadUser($userId);
        $this->renderPartial('_rubric_list', array('currentRubricId' => $currentRubricId));
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

        if ($model->author_id == 34531)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

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

    public function sitemapView($param)
    {
        $models = Yii::app()->db->createCommand()
            ->select('c.id, c.created, c.updated, c.author_id')
            ->from('community__contents c')
            ->join('community__rubrics r', 'c.rubric_id = r.id')
            ->join('community__content_types ct', 'c.type_id = ct.id')
            ->where('r.user_id IS NOT NULL AND c.type_id != :morning AND c.removed = 0 AND (c.uniqueness >= 50 OR c.uniqueness IS NULL)', array(':morning' => CommunityContent::TYPE_MORNING))
            ->limit(50000)
            ->offset(($param - 1) * 50000)
            ->order('c.id ASC')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'content_id' => $model['id'],
                    'user_id' => $model['author_id'],
                ),
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;
    }

    public function sitemapUser()
    {
        $models = Yii::app()->db->createCommand()
            ->select('u.id, c.updated, c.created')
            ->from('users u')
            ->join('community__contents c', 'c.author_id = u.id')
            ->where('c.removed = 0 AND (c.uniqueness >= 50 OR c.uniqueness IS NULL) AND c.type_id != 5')
            ->order('u.id ASC')
            ->group('u.id')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'user_id' => $model['id'],
                ),
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;
    }
}