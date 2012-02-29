<?php

class UserController extends Controller
{
    public function actionProfile($user_id)
    {
        Yii::import('application.widgets.user.*');

        $user = User::model()->with(array('status', 'purpose'))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        $this->render('profile', array(
            'user' => $user,
        ));
    }

    public function actionUpdateStatus()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $status = new UserStatus;
            $status->user_id = Yii::app()->user->id;
            $status->text = Yii::app()->request->getPost('text');
            if ($status->save()) {
                echo $this->renderPartial('application.widgets.user.views._status', array(
                    'status' => $status,
                    'canUpdate' => true,
                ));
            }
        }
    }
}
