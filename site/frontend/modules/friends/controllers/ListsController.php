<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/28/13
 * Time: 12:02 PM
 * To change this template use File | Settings | File Templates.
 */
class ListsController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly',
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

    public function actionBind()
    {
        $friendId = Yii::app()->request->getPost('friendId');
        $listId = Yii::app()->request->getPost('listId');
        $success = Friend::model()->updateByPk($friendId, array('list_id' => $listId)) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionUnbind()
    {
        $friendId = Yii::app()->request->getPost('friendId');
        $success = Friend::model()->updateByPk($friendId, array('list_id' => null)) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionCreate()
    {
        $title = Yii::app()->request->getPost('title');

        $list = new FriendList();
        $list->title = $title;
        $list->user_id = Yii::app()->user->id;
        $success = $list->save();

        $response = compact('success');
        if ($success) {
            $response['list'] = array(
                'id' => $list->id,
                'friendsCount' => (int) $list->friendsCount,
                'title' => $list->title,
            );
        }
        echo CJSON::encode($response);
    }

    public function actionDelete()
    {
        $listId = Yii::app()->request->getPost('listId');

        $success = FriendList::model()->deleteByPk($listId) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }
}
