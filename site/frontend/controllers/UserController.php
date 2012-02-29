<?php

class UserController extends Controller
{
    public function actionProfile($user_id)
    {
        Yii::import('application.widgets.user.*');
        Yii::import('application.modules.Interests.models.*');
        Yii::import('application.modules.geo.models.*');

        $user = User::model()->with(array(
            'status',
            'purpose',
        ))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        $this->render('profile', array(
            'user' => $user,
        ));
    }

    /*
     * @todo убрать $model->refresh()
     */
    public function actionCreateRelated($relation)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $entity = 'User' . ucfirst($relation);
            $model = new $entity;
            $model->user_id = Yii::app()->user->id;
            $model->text = Yii::app()->request->getPost('text');
            if ($model->save()) {
                $model->refresh();
                echo $this->renderPartial('application.widgets.user.views._' . $relation, array(
                    $relation => $model,
                    'canUpdate' => true,
                ));
            }
        }
    }
}
