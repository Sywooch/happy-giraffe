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
                $this->redirect(array('friendRequests/list'));
            }
        }

        $this->render('send', array(
            'model' => $model,
        ));
    }

    public function actionList()
    {
        $dataProvider = Yii::app()->user->model->friendRequests;

        $criteria = clone $dataProvider->getCriteria();
        $criteria->compare('to_id', Yii::app()->user->id);
        if (($pagination = $dataProvider->getPagination()) !== false) {
            $pagination->setItemCount($dataProvider->getTotalItemCount());
            $pagination->applyLimit($criteria);
        }
        FriendRequest::model()->updateAll(array('read_status' => true), $criteria);

        $this->render('list', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionReply($request_id, $new_status)
    {
        $request = FriendRequest::model()->findByPk($request_id);
        if ($request === null)
            throw new CHttpException(404, 'Запрос не найден');
        if ($request->to_id != Yii::app()->user->id)
            throw new CHttpException(403, 'Это не ваше приглашение');
        $request->status = $new_status;
        if ($request->save() && $new_status == 'accepted') {
            Yii::app()->user->model->addFriend($request->from_id);
        }
        $this->redirect(array('user/myFriendRequests', 'direction' => 'incoming'));
    }
}
