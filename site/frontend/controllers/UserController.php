<?php

class UserController extends Controller
{
    public function actionProfile($user_id)
    {
        $user = User::model()->with(array('status', 'purpose'))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        $this->render('profile', array(
            'user' => $user,
        ));
    }
}
