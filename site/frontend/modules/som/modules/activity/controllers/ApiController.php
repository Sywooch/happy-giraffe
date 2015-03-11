<?php

namespace site\frontend\modules\som\modules\activity\controllers;

use site\frontend\modules\som\modules\activity\models\Activity;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function actionCreate($userId, $typeId, $dtimeCreate, array $data, $hash)
    {
        $model = new Activity();
        $model->userId = $userId;
        $model->typeId = $typeId;
        $model->dtimeCreate = $dtimeCreate;
        $model->dataArray = $data;
        $model->hash = $hash;

        if ($model->save()) {
            $model->refresh();
            $this->success = true;
            $this->data = $model->toJSON();
        } else {
            $this->errorCode = 1;
            $this->errorMessage = $model->errors;
        }
    }

    public function actionHash($hash)
    {
        $model = Activity::model()->findByAttributes(array('hash' => $hash));
        if ($model) {
            $this->success = true;
            $this->data = $model->toJSON();
        } else {
            throw new \CHttpException(404);
        }
    }

    public function actionRemoveByHash($hash)
    {
        $model = Activity::model()->findByAttributes(array('hash' => $hash));
        if ($model) {
            $model->delete();
            $this->success = true;
            $this->data = array();
        } else {
            throw new \CHttpException(404);
        }
    }

}
