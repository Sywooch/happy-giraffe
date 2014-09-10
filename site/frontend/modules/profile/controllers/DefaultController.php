<?php

class DefaultController extends HController
{
    public $layout = 'user';
    public $tempLayout = true;
    /**
     * @var User
     */
    public $user;
    public $title;

    /**
     * Анкета пользователя $user_id
     * @param int $user_id
     * @throws CHttpException
     * @sitemap route=blog/default/index dataSource=sitemapView
     * @sitemap dataSource=sitemapView
     */
    public function actionIndex($user_id)
    {
        $this->layout = '//layouts/main';
        $this->loadUser($user_id);
        $this->pageTitle = $this->user->fullName . ' на Веселом Жирафе';
        $dataProvider = CommunityContent::model()->getUserContent($this->user);

        NoindexHelper::setNoIndex($this->user);

        $this->render('index', array('user' => $this->user, 'dataProvider' => $dataProvider));
    }

    /**
     * Раскрытие друзей пользователя $user_id
     * @param int $user_id
     */
    public function actionFriends($user_id, $page = 0)
    {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('site.frontend.modules.friends.components.*');
            $dataProvider = new CActiveDataProvider('Friend', array(
                'criteria' => array(
                    'condition' => 'user_id = :user_id',
                    'with' => array('friend'),
                    'params' => array(':user_id' => $user_id)
                ),
                'pagination' => array(
                    'pageSize' => 15,
                    'currentPage' => $page
                )
            ));
            $users = array_map(function ($friend) {
                return array(
                    'id' => null,
                    'user' => FriendsManager::userToJson($friend->friend),
                );
            }, $dataProvider->getData());
            $data = compact('users');
            echo CJSON::encode($data);
        } else {
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

            $this->loadUser($user_id);
            $this->title = 'Друзья';
            $dataProvider = new CActiveDataProvider('Friend', array(
                'criteria' => array(
                    'condition' => 'user_id = :user_id',
                    'with' => array('friend', 'friend.blogPostsCount'),
                    'params' => array(':user_id' => $this->user->id)
                ),
                'pagination' => array('pageSize' => 15)
            ));

            if (Yii::app()->request->isAjaxRequest)
                $this->layout = '//layouts/empty';
            $this->render('friends', compact('dataProvider'));
        }
    }

    public function actionAwards($user_id)
    {
        $this->loadUser($user_id);

        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->pageTitle = $this->user->getFullName() . ' - Награды';
        $this->title = 'Награды';

        $awards = UserScores::model()->getAwardsWithAchievements($this->user->id);

        $this->render('awards', compact('awards'));
    }

    public function actionAward($user_id, $id, $type)
    {
        $this->loadUser($user_id);
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        if ($type == 'award')
            $award = ScoreUserAward::model()->findByPk($id);
        elseif ($type == 'achievement')
            $award = ScoreUserAchievement::model()->findByPk($id);

        if ($award === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = $this->user->getFullName() . ' - ' . $award->getTitle();
        $this->title = 'Награды';

        list($next, $prev) = UserScores::getNextPrev($user_id, $award);
        list($users, $count) = $award->awardUsers();

        $this->render('award', compact('award', 'next', 'prev', 'users', 'count'));
    }

    /**
     * Сохранение информации "о себе" для текущего пользователя
     */
    public function actionAbout()
    {
        $user = Yii::app()->user->getModel();
        $user->about = Yii::app()->request->getPost('about');
        $user->update(array('about'));

        echo CJSON::encode(array('status' => true, 'about' => $user->about));
    }

    /**
     * Добавить или убрать (если есть) интерес для текущего пользователя
     */
    public function actionToggleInterest()
    {
        $interest_id = Yii::app()->request->getPost('id');
        echo CJSON::encode(array('status' => (bool)Interest::toggleInterest(Yii::app()->user->id, $interest_id)));
    }

    /**
     * Добавление пользовательского интереса
     */
    public function actionAddNewInterest()
    {
        $title = strip_tags(trim(Yii::app()->request->getPost('title')));
        $model = Interest::model()->findByAttributes(array('title' => $title));
        if ($model === null) {
            $model = new Interest();
            $model->title = $title;
            if (!$model->save()) {
                var_dump($model->getErrorsText());
                Yii::app()->end();
            }
        }

        echo CJSON::encode(array('status' => (bool)Interest::toggleInterest(Yii::app()->user->id, $model->id), 'id' => $model->id));
    }

    /**
     * Получение данных о интересе - кол-ве пользователей, у которых
     * этот интерес, аватарки пользователей
     */
    public function actionInterestData()
    {
        $id = Yii::app()->request->getPost('id');
        $interest = Interest::model()->findByPk($id);
        echo CJSON::encode(array(
            'status' => true,
            'users' => $interest->getUsersData(),
            'count' => (int)$interest->usersCount,
        ));
    }

    /**
     * Установить новый аватар
     */
    public function actionSetAvatar()
    {
        $source_id = Yii::app()->request->getPost('source_id');
        $coordinates = Yii::app()->request->getPost('coordinates');
        $ava = UserAvatar::createUserAvatar(Yii::app()->user->id, $source_id,
            $coordinates['x'], $coordinates['y'], $coordinates['w'], $coordinates['h']);
        User::clearCache();

        echo CJSON::encode(array('status' => true, 'url' => $ava->getOriginalUrl()));
    }

    public function actionSubscribeBlog()
    {
        $blog_id = Yii::app()->request->getPost('id');
        UserBlogSubscription::toggle($blog_id);
        echo CJSON::encode(array('status' => true));
    }

    public function actionSignup()
    {
        $clubs = Yii::app()->user->getState('visitedClubs', array());
        $blogs = Yii::app()->user->getState('visitedBlogs', array());
        foreach ($clubs as $clubId)
            UserClubSubscription::add($clubId);
        foreach ($blogs as $blogId)
            UserBlogSubscription::add($blogId);
        Yii::app()->user->setState('visitedClubs', null);
        Yii::app()->user->setState('visitedBlogs', null);

        $this->loadUser(Yii::app()->user->id);
        $this->layout = '//layouts/simple';
        $this->render('signup');
    }

    /**
     * Load user
     * @param int $id user id
     * @throws CHttpException
     */
    public function loadUser($id)
    {
        $this->user = User::model()->active()->findByPk($id);
        if ($this->user === null || $id == User::HAPPY_GIRAFFE)
            throw new CHttpException(404, 'Пользователь не найден.');
    }

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('u.id, c.updated, c.created')
            ->from('users u')
            ->join('community__contents c', 'c.author_id = u.id')
            ->where('u.deleted = 0 AND u.id != ' . User::HAPPY_GIRAFFE . ' AND c.removed = 0 AND (c.uniqueness >= 50 OR c.uniqueness IS NULL) AND c.type_id != 5')
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