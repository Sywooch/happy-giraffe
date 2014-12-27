<?php

namespace site\frontend\modules\users\controllers;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'get' => 'site\frontend\components\api\PackAction',
        ));
    }

    public function packGet($id, $avatarSize = false)
    {
        $user = \site\frontend\modules\users\models\User::model()->findByPk($id);
        if (!$user)
            throw new \CHttpException(404, 'Пользователь ' . $id . ' не найден');
        $this->success = true;
        $this->data = $user->toJSON();
        if ($avatarSize)
            $this->data['avatarUrl'] = $user->getAvatarUrl($avatarSize);
    }

    public function actionUpdate($id, array $attributes)
    {
        if (\Yii::app()->user->checkAccess('editSettings', array('userId' => $id))) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $user = $this->getModel('\site\frontend\modules\users\models\User', $id);
        $user->attributes = $attributes;
        $this->success = $user->save();
        $this->data = $user;
    }

    public function actionChangePassword($id, $password)
    {
        if (\Yii::app()->user->checkAccess('editSettings', array('userId' => $id))) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id);
        $user->password = \User::hashPassword($password);
        $this->success = $user->save();
        $this->data = $user;
    }
}

?>
