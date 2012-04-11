<?php

class UserController extends Controller
{
    public $layout = '//layouts/user';
    public $user;
    public $rubric_id;
    public $content_type_slug;

    private $_publicActions = array('profile', 'blog', 'friends', 'clubs');

    public function filters()
    {
        return array(
            'accessControl',
            'locationForm, saveLocation + ajaxOnly'
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
                'actions' => array('myFriendRequests', 'createRelated', 'updateMood'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    protected function beforeAction($action)
    {
        Yii::app()->clientScript->scriptMap = array(
            'global.css' => false,
        );

        $user_id = (in_array($this->action->id, $this->_publicActions)) ? $this->actionParams['user_id'] : Yii::app()->user->id;
        $this->user = User::model()->getUserById($user_id);
        if ($this->user === null)
            throw new CHttpException(404, 'Пользователь не найден');
        return parent::beforeAction($action);
    }

    public function actionProfile($user_id)
    {
        $this->layout = '//layouts/main';
        $this->pageTitle = 'Анкета';

        Yii::import('application.widgets.user.*');
        Yii::import('site.common.models.interest.*');

        $user = User::model()->active()->with(array(
            'status',
            'purpose',
        ))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');
        if (!$user->calculateAccess('profile_access', Yii::app()->user->id))
            throw new CHttpException(403, 'Вы не можете просматривать страницу этого пользователя');

        if ($user->id == Yii::app()->user->id) {
            UserNotification::model()->deleteByEntity(UserNotification::NEW_COMMENT, $user);
        }

        $this->render('profile', array(
            'user' => $user,
        ));
    }

    public function actionClubs($user_id)
    {
        $this->pageTitle = 'Клубы';
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
        $dataProvider->pagination = array(
            'pageSize' => 12,
        );
        $this->render('friends', array(
            'dataProvider' => $dataProvider,
            'show' => $show,
        ));
    }

    public function actionMyFriendRequests($direction)
    {
        $dataProvider = Yii::app()->user->model->getFriendRequests($direction);
        $dataProvider->pagination = array(
            'pageSize' => 12,
        );
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
            $user->mood_id = Yii::app()->request->getPost('mood_id');
            if ($user->save(true, array('mood_id'))) {
                echo $this->renderPartial('application.widgets.user.views._mood', array(
                    'mood' => $user->mood,
                    'canUpdate' => true,
                ));
            }
            else {
                print_r($user->errors);
            }
        }
    }
}