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
                'isFriend' => (bool) $interlocutorModel->isFriend(Yii::app()->user->id),
                'gender' => (bool) $interlocutorModel->gender,
            ),
            'blogPostsCount' => (int) $interlocutorModel->blogPostsCount,
            'photosCount' => (int) $interlocutorModel->photosCount,
        );

        echo CJSON::encode(compact('interlocutor'));
    }

    public function actionTyping()
    {
        $interlocutorId = Yii::app()->request->getPost('interlocutorId');
        $typingStatus = (bool) Yii::app()->request->getPost('typingStatus');

        $comet = new CometModel();
        $comet->send($interlocutorId, compact('typingStatus'), CometModel::MESSAGING_INTERLOCUTOR_TYPING);
    }
}
