<?php

class DefaultController extends HController
{
    public $layout = '//layouts/community';
    public $breadcrumbs = false;
    /**
     * @var Community
     */
    public $community;
    public $rubric_id;
    public $forum = false;

    public function beforeAction($action)
    {
        $this->community = Community::model()->findByPk(Yii::app()->request->getParam('community_id'));

        return parent::beforeAction($action);
    }

    /**
     * Главная страница сообщества
     * @param int $community_id
     */
    public function actionCommunity($community_id)
    {
        $moderators = $this->community->getModerators();

        $rubric_id = null;
        $this->render('community', compact('users', 'user_count', 'rubric_id', 'moderators'));
    }

    /**
     * Список статей форума сообщества
     *
     * @param int $community_id
     * @param int|null $rubric_id
     */
    public function actionForum($community_id, $rubric_id = null)
    {
        $this->layout = 'forum';
        $this->rubric_id = $rubric_id;
        $this->forum = true;

        $this->render('list');
    }

    public function actionView($community_id, $content_type_slug, $content_id)
    {
        $this->layout = 'forum';
        $this->forum = true;
        $content = $this->loadContent($content_id, $content_type_slug);
        if (!empty($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        $this->pageTitle = $content->title;
        $this->rubric_id = $content->rubric_id;

        if (!Yii::app()->user->isGuest){
            NotificationRead::getInstance()->setContentModel($content);
            UserPostView::getInstance()->checkView(Yii::app()->user->id, $content->id);
        }

        $this->render('view', compact('content'));
    }

    public function actionServices($community_id)
    {
        $services = $this->community->services;
        $this->render('services', compact('services'));
    }

    public function actionSubscribe()
    {
        $id = Yii::app()->request->getPost('community_id');
        if (!UserCommunitySubscription::subscribed(Yii::app()->user->id, $id))
            UserCommunitySubscription::add($id);
        echo CJSON::encode(array('status' => true));
    }

    /**
     * @param int $id model id
     * @param string $content_type_slug
     * @throws CHttpException
     * @return CommunityContent
     */
    public function loadContent($id, $content_type_slug){
        $content = CommunityContent::model()->findByPk($id);
        if ($content === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (!empty($content_type_slug) && !in_array($content_type_slug, array('post', 'video', 'photoPost')))
            throw new CHttpException(404, 'Страницы не существует');

        if ($this->community->id != $content->rubric->community->id || $content_type_slug != $content->type->slug) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        return $content;
    }
}