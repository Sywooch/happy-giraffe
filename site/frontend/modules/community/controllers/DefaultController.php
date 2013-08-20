<?php

class DefaultController extends HController
{
    public $layout = '//layouts/common_new';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionCommunity($community_id)
    {
        $community = Community::model()->findByPk($community_id);
        $users = UserCommunitySubscription::model()->getSubscribers($community->id);
        $user_count = UserCommunitySubscription::model()->getSubscribersCount($community->id);
        $moderators = $community->getModerators();

        $rubric_id = null;
        $this->render('community', compact('community', 'users', 'user_count', 'rubric_id', 'moderators'));
    }

    public function actionForum($community_id, $rubric_id = null)
    {
        $community = Community::model()->findByPk($community_id);
        $users = UserCommunitySubscription::model()->getSubscribers($community->id);
        $user_count = UserCommunitySubscription::model()->getSubscribersCount($community->id);

        $this->render('community', compact('community', 'users', 'user_count', 'rubric_id'));
    }

    public function actionView($community_id, $content_type_slug, $content_id)
    {

    }

    public function actionServices($community_id)
    {

    }

    public function actionSubscribe()
    {
        $id = Yii::app()->request->getPost('community_id');
        if (!UserCommunitySubscription::subscribed(Yii::app()->user->id, $id))
            UserCommunitySubscription::add($id);
        echo CJSON::encode(array('status' => true));
    }
}