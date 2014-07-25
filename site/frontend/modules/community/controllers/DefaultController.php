<?php

class DefaultController extends HController
{
    public $layout = '//layouts/community';
    public $breadcrumbs = false;
    /**
     * @var CommunityClub
     */
    public $club;
    public $rubric_id;
    public $forum;

    public function behaviors()
    {
        return array(
            'lastModified' => array(
                'class' => 'LastModifiedBehavior',
                'getParameter' => 'content_id',
                'entity' => 'CommunityContent',
            ),
        );
    }

    public function filters()
    {
        $filters = array();

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
                'COutputCache + forum',
                'duration' => 300,
                'varyByParam' => array('forum_id', 'rubric_id', 'CommunityContent_page'),
            );

            $filters [] = array(
                'COutputCache + club',
                'duration' => 300,
                'varyByParam' => array('club', 'CommunityContent_page'),
            );

            $filters [] = array(
                'COutputCache + section',
                'duration' => 300,
                'varyByParam' => array('section_id', 'CommunityContent_page'),
            );
        }

        return $filters;
    }

    protected function afterAction($action)
    {
        if ($this->club)
            Yii::app()->user->setState('last_club_id', $this->club->id);

        if (Yii::app()->user->isGuest && $this->club) {
            $clubs = Yii::app()->user->getState('visitedClubs', array());
            if (array_search($this->club->id, $clubs) === false) {
                $clubs[] = $this->club->id;
                Yii::app()->user->setState('visitedClubs', $clubs);
            }
        }
    }

    public function actionSection($section_id)
    {
        $this->layout = '//layouts/main';

        $section = $this->loadSection($section_id);
        $this->pageTitle = $section->title;
        $this->breadcrumbs = array($section->title);

        $this->render('section', compact('section'));
    }

    /**
     * Главная страница сообщества
     * @param int $club_id
     */
    public function actionClub($club)
    {

        $this->layout = '//layouts/main';
        $this->loadClub($club);
        $this->breadcrumbs = array(
            $this->club->section->title => $this->club->section->getUrl(),
            $this->club->title,
        );

        $this->pageTitle = $this->club->title;
        $moderators = $this->club->getModerators();

        $rubric_id = null;
        $this->render('club', compact('users', 'user_count', 'rubric_id', 'moderators'));
    }

    /**
     * Список статей форума сообщества
     *
     * @param int $forum_id
     * @param int|null $rubric_id
     */
    public function actionForum($forum_id, $rubric_id = null)
    {
        $this->forum = $this->loadForum($forum_id);
        $this->pageTitle = $this->forum->title;
        $this->layout = ($forum_id == Community::COMMUNITY_NEWS) ? '//layouts/news' : '//layouts/forum';
        $this->rubric_id = $rubric_id;

        if ($forum_id != Community::COMMUNITY_NEWS) {
            $this->breadcrumbs = array(
                $this->club->section->title => $this->club->section->getUrl(),
                $this->club->title => $this->club->getUrl()
            );
            $forumTitle = (isset($this->club->communities) && count($this->club->communities) > 1) ? $this->forum->title : 'Форум';
            if ($rubric_id !== null) {
                $rubric = CommunityRubric::model()->findByPk($rubric_id);
                if ($rubric === null)
                    throw new CHttpException(404);

                $this->breadcrumbs += array(
                    $forumTitle => $this->forum->getUrl(),
                    $rubric->title,
                );
            } else
                $this->breadcrumbs[] = $forumTitle;
        }

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $dp = CommunityContent::model()->getContents($this->forum->id, $rubric_id);

        $this->render('list', compact('dp'));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($forum_id, $content_type_slug, $content_id)
    {
        $this->forum = $this->loadForum($forum_id);
        $this->layout = ($forum_id == Community::COMMUNITY_NEWS) ? '//layouts/news' : '//layouts/forum';
        $content = $this->loadContent($content_id, $content_type_slug);
        if ($content->type_id == 1)
            $content
                ->getContent()
                ->forEdit
                ->text;
        if (is_int($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        if ($content->contestWork !== null)
            $this->bodyClass = 'theme-contest theme-contest__' . $content->contestWork->contest->cssClass;

        $this->pageTitle = $content->title;
        $this->rubric_id = $content->rubric_id;

        if ($forum_id != Community::COMMUNITY_NEWS)
            $this->breadcrumbs = array(
                $this->club->section->title => $this->club->section->getUrl(),
                $this->club->title => $this->club->getUrl(),
                (isset($this->club->communities) && count($this->club->communities) > 1) ? $this->forum->title : 'Форум' => $this->forum->getUrl(),
                $content->rubric->title => $content->rubric->getUrl(),
                $content->title,
            );

        if (!Yii::app()->user->isGuest) {
            NotificationRead::getInstance()->setContentModel($content);
            UserPostView::getInstance()->checkView(Yii::app()->user->id, $content->id);
        }

        $this->render('view', compact('content'));
    }

    public function actionServices($club)
    {
        $this->loadClub($club);
        $this->pageTitle = $this->club->title.' - Сервисы';
        $this->breadcrumbs = array(
            $this->club->section->title => $this->club->section->getUrl(),
            $this->club->title => $this->club->getUrl(),
            'Сервисы'
        );

        $services = $this->club->services;
        $this->render('services', compact('services'));
    }

    public function actionSubscribe()
    {
        $id = Yii::app()->request->getPost('community_id');
        if (!UserClubSubscription::subscribed(Yii::app()->user->id, $id))
            UserClubSubscription::add($id);
        echo CJSON::encode(array('status' => true));
    }

    public function actionSave($id = null)
    {
        $contest_id = Yii::app()->request->getPost('contest_id');
        $model = ($id === null) ? new CommunityContent() : CommunityContent::model()->findByPk($id);
        if (! $model->isNewRecord && ! $model->canEdit())
            throw new CHttpException(403);
        $model->scenario = 'default_club';
        $model->attributes = $_POST['CommunityContent'];
        if ($id === null)
            $model->author_id = Yii::app()->user->id;
        $slug = $model->type->slug;
        $slaveModelName = 'Community' . ucfirst($slug);
        $slaveModel = ($id === null) ? new $slaveModelName() : $model->content;
        $slaveModel->attributes = $_POST[$slaveModelName];
        if ($contest_id !== null)
            $slaveModel->isContestWork = true;
        $this->performAjaxValidation(array($model, $slaveModel));
        $model->$slug = $slaveModel;
        if ($contest_id !== null) {
            $contestWork = new CommunityContestWork();
            $contestWork->contest_id = $contest_id;
            $model->contestWork = $contestWork;
            $success = $model->withRelated->save(true, array(
                $slug,
                'contestWork',
            ));
        }
        else
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

    public function actionCreateQuestion()
    {
        $model = new CommunityQuestionForm();

        $this->performAjaxValidation($model);

        if (isset($_POST['CommunityQuestionForm'])) {
            $model->attributes = $_POST['CommunityQuestionForm'];
            if ($model->validate() && $model->save())
                $this->redirect($model->post->url);
        }

//        print_r($model->errors);

//        if (Yii::app()->user->isGuest) {
//            $user = new User('signupQuestion');
//            $user->attributes = $_POST['User'];
//            $user->registration_finished = 0;
//            $user->registration_source = User::REGISTRATION_SOURCE_QUESTION;
//        } else
//            $user = Yii::app()->user->model;
//
//        $model = new CommunityContent('default_club');
//        $model->attributes = $_POST['CommunityContent'];
//        $model->author_id = $user->id;
//        $slaveModel = new CommunityQuestion();
//        $slaveModel->attributes = $_POST['CommunityQuestion'];
//        $model->question = $slaveModel;
//        $this->performAjaxValidation(array($user, $model, $slaveModel));
//        $user->communityPosts = array($model);
//        $success = $user->withRelated->save(true, array('communityPosts' => array('question')));
//        if ($success) {
//            Yii::app()->user->setState('newUser', array('id' => $user->id, 'email' => $user->email, 'first_name' => $user->first_name));
//            $this->redirect($model->url);
//        }
//        else {
//            echo 'Root:<br />';
//            var_dump($model->getErrors());
//            echo 'Slave:<br />';
//            var_dump($slaveModel->getErrors());
//        }
    }

    public function actionPhotoWidget($contentId)
    {
        $content = CommunityContent::model()->with('gallery', 'gallery.widget')->findByPk($contentId);
        if ($content === null)
            throw new CHttpException(404);

        $title = $content->gallery->widget === null ? $content->title : $content->gallery->widget->title;
        $photos = array_map(function($item) {
            return array(
                'id' => $item->id,
                'url' =>  $item->photo->getPreviewUrl(480, 250),
            );
        }, $content->gallery->items);
        $checkedPhoto = $content->gallery->widget === null ? null : $content->gallery->widget->item->id;
        $hidden = $content->gallery->widget === null ? false : (bool) $content->gallery->widget->hidden;
        $widgetId = $content->gallery->widget === null ? null : $content->gallery->widget->id;
        $contentId = $content->id;

        $json = compact('title', 'photos', 'hidden', 'checkedPhoto', 'widgetId', 'contentId');
        $this->renderPartial('photoWidget', compact('json'));
    }

    public function actionPhotoWidgetSave()
    {
        $widgetId = Yii::app()->request->getPost('widgetId');
        if ($widgetId === null) {
            $contentId = Yii::app()->request->getPost('contentId');
            $content = CommunityContent::model()->findByPk($contentId);
            $widget = new CommunityContentGalleryWidget();
            $widget->gallery_id = $content->gallery->id;
            $widget->club_id = $content->rubric->community->club_id;
        } else
            $widget = CommunityContentGalleryWidget::model()->findByPk($widgetId);
        $widget->hidden = (int) CJSON::decode(Yii::app()->request->getPost('hidden'));
        $widget->item_id = Yii::app()->request->getPost('item_id');
        $widget->title = Yii::app()->request->getPost('title');
        $success = $widget->save();

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionClubFavourites($clubId, $type = null)
    {
        if (Yii::app()->user->isGuest || Yii::app()->user->model->group == UserGroup::USER || ! Yii::app()->user->model->checkAuthItem('clubFavourites'))
            throw new CHttpException(404);

        $this->club = CommunityClub::model()->findByPk($clubId);
        if ($this->club === null)
            throw new CHttpException(404);

        $dp = $this->club->getFavourites($type);

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->render('clubFavourites', compact('dp', 'type'));
    }

    public function actionClubPhotoPosts($clubId)
    {
        if (Yii::app()->user->isGuest || Yii::app()->user->model->group == UserGroup::USER || ! Yii::app()->user->model->checkAuthItem('clubFavourites'))
            throw new CHttpException(404);

        $this->club = CommunityClub::model()->findByPk($clubId);
        if ($this->club === null)
            throw new CHttpException(404);

        $dp = CommunityContent::model()->getClubContents($clubId, CommunityContent::TYPE_PHOTO_POST);

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->render('clubPhotoPosts', compact('dp'));
    }

    protected function performAjaxValidation($models)
    {
        if (isset($_POST['ajax']) && in_array($_POST['ajax'], array('blog-form', 'question-form'), true)) {
            echo CActiveForm::validate($models);
            Yii::app()->end();
        }
    }

    /**
     * @param int $id model id
     * @param string $content_type_slug
     * @throws CHttpException
     * @return CommunityContent
     */
    public function loadContent($id, $content_type_slug)
    {
        $content = CommunityContent::model()->findByPk($id);
        if ($content === null || $content->getIsFromBlog())
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (!empty($content_type_slug) && !in_array($content_type_slug, array('post', 'video', 'photoPost', 'question')))
            throw new CHttpException(404, 'Страницы не существует');

        if ($this->forum !== null && $this->forum->id != $content->rubric->community->id || $content_type_slug != $content->type->slug) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        if ($content->author_id == 34531)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        return $content;
    }

    /**
     * @param int $id model id
     * @return CommunitySection
     * @throws CHttpException
     */
    public function loadSection($id)
    {
        $model = CommunitySection::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param string $slug model slug
     * @return CommunityClub
     * @throws CHttpException
     */
    public function loadClub($slug)
    {
        $this->club = CommunityClub::model()->findByAttributes(array('slug' => $slug));
        if ($this->club === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }

    /**
     * @param int $id model id
     * @return Community
     * @throws CHttpException
     */
    public function loadForum($id)
    {
        $model = Community::model()->cache(3600)->with('rootRubrics', 'rootRubrics.childs')->findByPk($id);
        $this->club = $model->club;
        if ($model === null || ($this->club === null && !in_array($model->id, array(36))))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function getUrl($overwrite = array(), $route = '/community/default/forum')
    {
        $params = array_filter(CMap::mergeArray(
            array(
                'forum_id' => $this->forum->id,
                'rubric_id' => isset($this->actionParams['rubric_id']) ? $this->actionParams['rubric_id'] : null,
                'content_type_slug' => isset($this->actionParams['content_type_slug']) ? $this->actionParams['content_type_slug'] : null,
            ),
            $overwrite
        ));

        return $this->createUrl($route, $params);
    }

    public function sitemapView($param)
    {
        $models = Yii::app()->db->createCommand()
            ->select('c.id, c.created, c.updated, r.community_id, ct.slug')
            ->from('community__contents c')
            ->join('community__rubrics r', 'c.rubric_id = r.id')
            ->join('community__content_types ct', 'c.type_id = ct.id')
            ->where('r.community_id IS NOT NULL AND c.removed = 0 AND (c.uniqueness >= 50 OR c.uniqueness IS NULL)')
            ->limit(50000)
            ->offset(($param - 1) * 50000)
            ->order('c.id ASC')
            ->queryAll();

        $data = array();
        foreach ($models as $model) {
            $data[] = array(
                'params' => array(
                    'content_id' => $model['id'],
                    'forum_id' => $model['community_id'],
                    'content_type_slug' => $model['slug'],
                ),
                'priority' => 0.5,
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;
    }

    public function actionContacts()
    {
        $this->forum = Community::model()->findByPk(Community::COMMUNITY_NEWS);
        $this->pageTitle = 'О нас';
        $this->layout = '//layouts/news';
        $this->render('contacts');
    }
}