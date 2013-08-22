<?php

class DefaultController extends HController
{
    public $layout = 'subscribes';

    public function actionIndex()
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