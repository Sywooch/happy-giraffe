<?php

class FriendRequestsController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
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

    public function actionSend($to_id)
    {
        $model = new FriendRequest;

        if (isset($_POST['FriendRequest'])) {
            $model->attributes = $_POST['FriendRequest'];
            $model->from_id = Yii::app()->user->id;
            $model->to_id = $to_id;
            if ($model->save()) {
                $this->redirect(array('user/myInvites'));
            }
        }

        $this->render('send', array(
            'model' => $model,
        ));
    }

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('FriendRequest', array(
            'criteria'=>array(
                'condition' => 'from_id = :user_id OR to_id = :user_id',
                'params' => array(':user_id' => Yii::app()->user->id),
                'with' => array('from', 'to'),
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));

        $this->render('list', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionReply($request_id, $new_status)
    {
        if (Yii::app()->request->isAjaxRequest) {

        } else {
            $request = FriendRequest::model()->findByPk($request_id);
            if ($request === null)
                throw new CHttpException(404, 'Запрос не найден');
            if ($request->to_id != Yii::app()->user->id)
                throw new CHttpException(403, 'Это не ваше приглашение');
            $request->new_status = $new_status;
            if ($request->save()) {
                $user = Yii::app()->user->model;
            }
        }
    }
}
