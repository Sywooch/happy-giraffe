<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 9/12/12
 * Time: 9:54 AM
 * To change this template use File | Settings | File Templates.
 */
class UserPopupController extends HController
{
    public function filters()
    {
        return array(
            //'ajaxOnly',
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'backColor' => 0xFFFFFF,
                'width' => 125,
                'height' => 46,
                'onlyDigits' => TRUE,
            ),
        );
    }

    public function actionSettings()
    {
        $this->renderPartial('settings', array('model' => Yii::app()->user->model), false, true);
    }

    public function actionChangePassword()
    {
        $model = Yii::app()->user->model;
        $model->scenario = 'change_password';
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate(array('current_password', 'new_password', 'new_password_repeat', 'verifyCode'))) {
                $model->password = $model->new_password;
                echo CJavaScript::encode($model->update(array('password')));
            }
        }
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='password-form')
        {
            echo CActiveForm::validate($model, array('current_password', 'new_password', 'new_password_repeat', 'verifyCode'));
            Yii::app()->end();
        }
    }

    public function actionNotifications()
    {
        $dp = UserNotification::model()->getUserNotifications(Yii::app()->user->id);

        $this->renderPartial('notifications', compact('dp'), false, true);
    }

    public function actionFriends()
    {
        $requests = Yii::app()->user->model->getFriendRequests('incoming');
        $requests->pagination->pageSize = 999;
        $hasInvitations = $requests->itemCount > 0;
        $findFriends = Yii::app()->user->model->findFriends($hasInvitations ? 4 : 8);

        $friendsCount = Yii::app()->user->model->getFriendsCount();

        $lastFriendCriteria = Yii::app()->user->model->getFriendsCriteria(array(
            'order' => 'friends.created DESC',
        ));

        $lastFriend = User::model()->find($lastFriendCriteria);

        $newsCriteria = UserAction::model()->getFriendsCriteria(Yii::app()->user->id);
        $newsCriteria->limit = 3;
        $news = UserAction::model()->findAll($newsCriteria);

        $this->renderPartial('friends', compact('requests', 'friendsCount', 'lastFriend', 'hasInvitations', 'findFriends', 'news'), false, true);
    }

    public function actionTest()
    {
        $rUsers = User::model()->findAll(array(
            'order' => 'RAND()',
            'limit' => 20,
            'condition' => 'id != 12936',
        ));

        foreach ($rUsers as $u) {
            $r = new FriendRequest;
            $r->from_id = $u->id;
            $r->to_id = 12936;
            $r->save();
        }
    }
}
