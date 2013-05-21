<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/11/13
 * Time: 4:03 PM
 * To change this template use File | Settings | File Templates.
 */
class InterlocutorsController extends HController
{
    public function actionGet($interlocutorId)
    {
        $interlocutorModel = User::model()->with('avatar')->findByPk($interlocutorId);
        $interlocutor = array(
            'user' => array(
                'id' => (int) $interlocutorModel->id,
                'firstName' => $interlocutorModel->first_name,
                'lastName' => $interlocutorModel->last_name,
                'avatar' => $interlocutorModel->getAva(),
                'online' => (bool) $interlocutorModel->online,
                'isFriend' => (bool) Friend::model()->areFriends(Yii::app()->user->id, $interlocutorId),
                'gender' => (bool) $interlocutorModel->gender,
            ),
            'blogPostsCount' => (int) $interlocutorModel->blogPostsCount,
            'photosCount' => (int) $interlocutorModel->photosCount,
            'inviteSent' => (bool) $interlocutorModel->isInvitedBy(Yii::app()->user->id),
            'isBlocked' => (bool) Blacklist::model()->isBlocked($interlocutorModel->id, Yii::app()->user->id),
        );

        echo CJSON::encode(compact('interlocutor'));
    }

    public function actionTyping()
    {
        $interlocutorId = Yii::app()->request->getPost('interlocutorId');
        $typingStatus = (bool) Yii::app()->request->getPost('typingStatus');

        $comet = new CometModel();
        $comet->send($interlocutorId, array('typingStatus' => $typingStatus, 'interlocutorId' => Yii::app()->user->id), CometModel::MESSAGING_INTERLOCUTOR_TYPING);
    }

    public function actionBlackList()
    {
        $interlocutorId = Yii::app()->request->getPost('interlocutorId');

        $bl = new Blacklist();
        $bl->user_id = Yii::app()->user->id;
        $bl->blocked_user_id = $interlocutorId;
        $success = $bl->save();

        $response = array(
            'success' => $success,
        );

        echo CJSON::encode($response);
    }
}
