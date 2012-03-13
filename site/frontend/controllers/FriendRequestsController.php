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
                UserFriendNotification::model()->createByRequest(UserFriendNotification::FRIEND_INVITE, $model);
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

    public function actionUpdate($request_id, $action)
    {
        $request = FriendRequest::model()->findByPk($request_id);
        if ($request === null)
            throw new CHttpException(404, 'Запрос не найден');
        switch ($action) {
            case 'accept':
                if ($request->to_id != Yii::app()->user->id)
                    throw new CHttpException(403, 'Это не ваше приглашение');
                $request->status = 'accepted';
                if ($request->save()) {
                    Yii::app()->user->model->addFriend($request->from_id);
                }
                break;
            case 'decline':
                if ($request->to_id != Yii::app()->user->id)
                    throw new CHttpException(403, 'Это не ваше приглашение');
                $request->status = 'declined';
                $request->save();
                break;
            case 'retry':
                if ($request->from_id != Yii::app()->user->id)
                    throw new CHttpException(403, 'Это не ваше приглашение');
                $request->save();
                break;
            case 'cancel':
                if ($request->from_id != Yii::app()->user->id)
                    throw new CHttpException(403, 'Это не ваше приглашение');
                $request->delete();
                break;
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}
