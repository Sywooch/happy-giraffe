<?php

class DefaultController extends HController
{
    public $layout = 'user';
    public $tempLayout = true;
    public $user;

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
            'avatar' => array('select' => array('fs_name', 'author_id')),
            'address' => array('select' => array('country_id', 'region_id', 'city_id')),
            'partner',
            'babies',
            'mood',
            'score',
            'albumsCount',
        ))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');

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
                    'currentPage'=>$page
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
            $this->pageTitle = 'Друзья';
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