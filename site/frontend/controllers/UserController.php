<?php

class UserController extends HController
{
    public $layout = '//layouts/user';
    /**
     * @var User
     */
    public $user;
    public $rubric_id;
    public $content_type_slug;

    private $_publicActions = array('profile', 'activity', 'blog', 'friends', 'clubs', 'rss');

    public function filters()
    {
        return array(
            'accessControl',
            'updateMood,createRelated + ajaxOnly'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => $this->_publicActions,
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('myFriendRequests', 'createRelated', 'updateMood', 'activityAll'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    protected function beforeAction($action)
    {
        if ($this->action->id != 'profile')
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        Yii::app()->clientScript->scriptMap = array(
            'global.css' => false,
        );

        $user_id = (in_array($this->action->id, $this->_publicActions)) ? $this->actionParams['user_id'] : Yii::app()->user->id;

        if ($this->action->id != 'profile') {
            $this->user = User::model()->active()->with('avatar', 'status')->findByPk($user_id);
            if ($this->user === null)
                throw new CHttpException(404, 'Пользователь не найден');
        }
        return parent::beforeAction($action);
    }

    public function actionProfile($user_id)
    {
        $this->layout = '//layouts/main';

        Yii::import('application.widgets.user.*');
        Yii::import('application.modules.whatsNew.widgets.whatsNewUserWidget.WhatsNewUserWidget');
        Yii::import('site.common.models.interest.*');
        Yii::import('site.frontend.modules.contest.models.*');

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $user_id);
        $criteria->scopes = array('active');
        $criteria->with = array(
            'status',
            'purpose',
            'avatar' => array('select' => array('fs_name', 'author_id')),
            'address' => array('select' => array('country_id', 'region_id', 'city_id')),
            'partner',
            'babies',
            'mood',
            'score',
//            'communities',
            'albumsCount',
        );
        $user = User::model()->find($criteria);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        foreach ($this->actionParams as $p => $v)
            if ($p == 'Comment_page' || $p == 'FriendEvent_page') {
                Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
            }
        //if (!$user->calculateAccess('profile_access', Yii::app()->user->id))
        //    throw new CHttpException(403, 'Вы не можете просматривать страницу этого пользователя');

        $this->pageTitle = $user->fullName . ' на Веселом Жирафе';

        if (!Yii::app()->user->isGuest)
            UserNotification::model()->deleteByEntity($user, Yii::app()->user->id);

        $this->render('profile', array(
            'user' => $user,
        ));
    }

    public function actionClubs($user_id)
    {
        $this->pageTitle = 'Клубы';
        $this->layout = 'user_new';
        $this->render('clubs');
    }

    public function actionBlog($user_id, $rubric_id = null)
    {
        $this->layout = '//layouts/user_blog';
        $this->user = User::model()->with('blog_rubrics')->findByPk($user_id);
        if ($this->user === null)
            throw new CHttpException(404, 'Клуб не найден');
        $this->rubric_id = $rubric_id;

        $contents = CommunityContent::model()->getBlogContents($user_id, $rubric_id);
        $this->render('blog', array(
            'contents' => $contents,
        ));
    }

    public function actionFriends($user_id, $show = 'all')
    {
        $this->pageTitle = 'Друзья';
        $dataProvider = ($show == 'online') ? $this->user->getFriends('online = 1') : $this->user->getFriends();
        $dataProvider->criteria->mergeWith(array('with'=>'avatar'));
        $dataProvider->pagination = array(
            'pageSize' => 30,
        );
        $this->layout = 'user_new';
        $this->render('friends', array(
            'dataProvider' => $dataProvider,
            'show' => $show,
        ));
    }

    public function actionMyFriendRequests($direction)
    {
        $dataProvider = Yii::app()->user->model->getFriendRequests($direction);
        $dataProvider->pagination = array(
            'pageSize' => 30,
        );
        $this->layout = 'user_new';
        $this->render('myFriendRequests', array(
            'dataProvider' => $dataProvider,
            'direction' => $direction,
        ));
    }

    /*
     * @todo убрать $model->refresh()
     */
    public function actionCreateRelated($relation)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $entity = 'User' . ucfirst($relation);
            $model = new $entity;
            $model->user_id = Yii::app()->user->id;
            $model->text = Yii::app()->request->getPost('text');
            if ($model->save()) {
                $model->refresh();
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('application.widgets.user.views._' . $relation, array(
                        $relation => $model,
                        'canUpdate' => true,
                    ), true),
                );
            } else {
                $response = array(
                    'status' => false,
                );
            }
            echo CJSON::encode($response);
        }
    }

    public function actionUpdateMood()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $user = Yii::app()->user->model;
            $mood_id = Yii::app()->request->getPost('mood_id');
            if ($mood_id > 35 && !$user->hasFeature(4))
                throw new CHttpException(404);
            $user->mood_id = $mood_id;

            if ($user->save(true, array('mood_id'))) {
                echo $this->renderPartial('application.widgets.user.views._mood', array(
                    'mood' => $user->mood,
                    'canUpdate' => true,
                ));
            } else {
                print_r($user->errors);
            }
        }
    }

    public function actionRss($user_id)
    {
        Yii::import('ext.EFeed.*');
        $feed = new EFeed();

        $feed->title = 'Веселый Жираф - сайт для всей семьи';
        $feed->description = 'Социальная сеть для родителей и их детей';
        $feed->setImage('Веселый Жираф - сайт для всей семьи', 'http://www.happy-giraffe.ru/rss/', 'http://www.happy-giraffe.ru/images/logo_2.0.png');
        $feed->addChannelTag('language', 'ru-ru');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', 'http://www.happy-giraffe.ru/rss/');

        if ($user_id == 1) {
            $criteria = new CDbCriteria(array(
                'condition' => 'type_id = 4 OR by_happy_giraffe = 1',
                'params' => array(':author_id' => $this->user->id),
                'limit' => 20,
                'order' => 'created DESC',
            ));
        } else {
            $criteria = new CDbCriteria(array(
                'condition' => 'author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0',
                'params' => array(':author_id' => $this->user->id),
                'limit' => 20,
                'order' => 'created DESC',
            ));
        }
        $contents = CommunityContent::model()->full()->findAll($criteria);

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            $item->title = $c->title;
            $item->link = $c->getUrl(false, true);
            $item->date = $c->created;
            $item->description = $c->preview;
            $item->addTag('author', $c->author->email);
            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }
}