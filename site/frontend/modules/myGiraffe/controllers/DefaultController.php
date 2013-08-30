<?php

class DefaultController extends HController
{
    public $layout = 'subscribes';
    /**
     * @var User
     */
    public $user;

    public function beforeAction($action)
    {
        $this->user = Yii::app()->user->getModel();
        return parent::beforeAction($action);
    }

    public function actionIndex($type = SubscribeDataProvider::TYPE_ALL, $community_id = null){
        $this->layout = '//layouts/main';

        $dp = SubscribeDataProvider::getDataProvider($this->user->id, $type, $community_id);
        $communities = Community::model()->findAllByPk(UserCommunitySubscription::getSubUserCommunities($this->user->id));

        $this->render('my_giraffe', compact('dp', 'communities', 'type', 'community_id'));
    }

    public function actionSubscribes()
    {
        $blog_subscriptions = User::model()->findAllByPk(UserBlogSubscription::getSubUserIds(Yii::app()->user->id));
        $this->render('index', compact('blog_subscriptions'));
    }

    public function actionRecommends()
    {
        $blog_subscriptions = User::model()->findAllByPk(UserBlogSubscription::getTopSubscription(Yii::app()->user->id));
        $this->render('recommends', compact('blog_subscriptions'));
    }
}