<?php

class DefaultController extends HController
{
    public $layout = 'user';
    public $tempLayout = true;
    public $user;
    public $title;

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    /**
     * Анкета пользователя $user_id
     * @param int $user_id
     * @throws CHttpException
     */
    public function actionIndex($user_id)
    {
        $this->layout = '//layouts/common_new';
        $user = User::model()->active()->with(array(
            'status',
            'purpose',
            'avatar',
            'address',
            'partner',
            'babies',
            'mood',
            'score',
            'albumsCount',
        ))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');
        $this->pageTitle = $user->fullName . ' на Веселом Жирафе';

        $this->render('index', compact('user'));
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
                    'with' => array('friend', 'friend.blogPostsCount'),
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
        $this->title = 'Награды';
        $awards = UserScores::model()->getAwardsWithAchievements($this->user->id);

        $this->render('awards', compact('awards'));
    }

    public function actionAward($user_id, $id, $type)
    {
        $this->loadUser($user_id);
        $this->title = 'Награды';
        if ($type == 'award')
            $award = ScoreUserAward::model()->findByPk($id);
        elseif ($type == 'achievement')
            $award = ScoreUserAchievement::model()->findByPk($id); else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
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

        echo CJSON::encode(array('status' => true, 'url' => $ava->getOriginalUrl()));
    }

    /**
     * Load user
     * @param int $id user id
     * @throws CHttpException
     */
    public function loadUser($id)
    {
        $this->user = User::model()->active()->findByPk($id);
        if ($this->user === null)
            throw new CHttpException(404, 'Пользователь не найден.');
    }
}