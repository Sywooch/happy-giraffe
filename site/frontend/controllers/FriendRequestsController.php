<?php

class FriendRequestsController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + send, delete, update'
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionSend()
    {
        $to_id = Yii::app()->request->getPost('to_id');
        $model = new FriendRequest;
        $model->from_id = Yii::app()->user->id;
        $model->to_id = $to_id;
        if ($model->save()) {
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('//user/_friend_button', array(
                    'user' => $model->to,
                ), true),
            );
        } else {
            $response = array(
                'status' => false,
                'error'=>$model->getErrorsText()
            );
        }
        echo CJSON::encode($response);
    }

    public function actionDelete()
    {
        $friend_id = Yii::app()->request->getPost('friend_id');
        if (Yii::app()->user->model->delFriend($friend_id)) {
            $model = User::model()->findByPk($friend_id);
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('//user/_friend_button', array(
                    'user' => $model,
                ), true),
            );
        } else {
            $response = array(
                'status' => false,
            );
        }
        echo CJSON::encode($response);
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
        if (! Yii::app()->request->isAjaxRequest)
            $this->redirect(Yii::app()->request->urlReferrer);
    }
}
