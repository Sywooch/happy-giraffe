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
            'id' => (int) $interlocutorModel->id,
            'firstName' => $interlocutorModel->first_name,
            'lastName' => $interlocutorModel->last_name,
            'online' => (bool) $interlocutorModel->online,
            'avatar' => $interlocutorModel->getAva(),
            'blogPostsCount' => (int) $interlocutorModel->blogPostsCount,
            'photosCount' => (int) $interlocutorModel->photosCount,
            'isFriend' => (bool) $interlocutorModel->isFriend(Yii::app()->user->id),
        );

        echo CJSON::encode(compact('interlocutor'));
    }
}
