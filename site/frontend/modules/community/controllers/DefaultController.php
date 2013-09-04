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
    public function actionClub($club_id)
    {
        $this->layout = '//layouts/main';
        $this->loadClub($club_id);
        $this->breadcrumbs = array($this->club->section->title => $this->club->section->getUrl(), $this->club->title);

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
        $forum = $this->loadForum($forum_id);
        $this->pageTitle = $forum->title;
        $this->layout = '//layouts/forum';
        $this->rubric_id = $rubric_id;
        $this->forum = $forum;

        $this->breadcrumbs = array(
            $this->club->section->title => $this->club->section->getUrl(),
            $this->club->title => $this->club->getUrl(),
            $this->forum->title
        );

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->render('list', $forum);
    }

    public function actionView($forum_id, $content_type_slug, $content_id)
    {
        $forum = $this->loadForum($forum_id);
        $this->layout = '//layouts/forum';
        $this->forum = $forum;
        $content = $this->loadContent($content_id, $content_type_slug);
        if (!empty($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        $this->pageTitle = $content->title;
        $this->rubric_id = $content->rubric_id;

        if (!Yii::app()->user->isGuest) {
            NotificationRead::getInstance()->setContentModel($content);
            UserPostView::getInstance()->checkView(Yii::app()->user->id, $content->id);
        }

        $this->render('view', compact('content'));
    }

    public function actionServices($club_id)
    {
        $this->loadClub($club_id);

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
        $model = ($id === null) ? new CommunityContent() : CommunityContent::model()->findByPk($id);
        $model->scenario = 'default_club';
        $model->attributes = $_POST['CommunityContent'];
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

    protected function performAjaxValidation($models)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-form') {
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
        if ($content === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (!empty($content_type_slug) && !in_array($content_type_slug, array('post', 'video', 'photoPost')))
            throw new CHttpException(404, 'Страницы не существует');

        if ($this->club->id != $content->rubric->community->club_id || $content_type_slug != $content->type->slug) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

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
     * @param int $id model id
     * @return CommunityClub
     * @throws CHttpException
     */
    public function loadClub($id)
    {
        $this->club = CommunityClub::model()->findByPk($id);
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
        $model = Community::model()->findByPk($id);
        $this->club = $model->club;
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}