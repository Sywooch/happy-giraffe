<?php

class DefaultController extends HController
{
    public $layout = 'subscribes';
    /**
     * @var User
     */
    public $user;

    public function filters()
    {
        return array(
            'accessControl',
            'onlyNew + onlyAjax'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($action)
    {
        $this->user = Yii::app()->user->getModel();
        return parent::beforeAction($action);
    }

    public function actionIndex($type = SubscribeDataProvider::TYPE_ALL, $community_id = null)
    {
        $this->layout = '//layouts/main';
        $this->pageTitle = 'Мой Жираф';

        $dp = SubscribeDataProvider::getDataProvider($this->user->id, $type, $community_id);
        $communities = CommunityClub::model()->findAllByPk(CUserSubscriptions::getInstance($this->user->id)->getSubUserClubIds());
        if ($dp->getTotalItemCount() == 0 && UserAttributes::get(Yii::app()->user->id, 'my_giraffe_only_new') == 0)
            $this->redirect($this->createUrl('recommends'));

        $this->render('my_giraffe', compact('dp', 'communities', 'type', 'community_id'));
    }

    public function actionSubscribes()
    {
        $this->pageTitle = 'Мои подписки';

        $blog_subscriptions = User::model()->findAllByPk(UserBlogSubscription::getSubUserIds(Yii::app()->user->id));
        $this->render('subscribes', compact('blog_subscriptions'));
    }

    public function actionRecommends()
    {
        $this->pageTitle = 'Рекомендация подписок';

        $blog_subscriptions = User::model()->findAllByPk(UserBlogSubscription::getTopSubscription(Yii::app()->user->id));
        $clubs = CUserSubscriptions::getInstance($this->user->id)->getNotSubscribedClubIds();
        $this->render('recommends', compact('blog_subscriptions', 'clubs'));
    }

    public function actionOnlyNew()
    {
        $val = Yii::app()->request->getPost('val');

        UserAttributes::set(Yii::app()->user->id, 'my_giraffe_only_new', $val);
        echo CJSON::encode(array('success' => true));
    }

    public function actionUnsubscribe()
    {
        UserAttributes::set(Yii::app()->user->id, 'horoscope_subscribe', 0);
        echo CJSON::encode(array('success' => true));
    }

    public function actionHidePopular()
    {
        UserAttributes::set(Yii::app()->user->id, 'popular_hide', 1);
        echo CJSON::encode(array('success' => true));
    }
}