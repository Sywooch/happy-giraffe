<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 16/01/14
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

class CheckController extends HController
{
    /**
     * Все хорошо
     */
    public function actionMarkGoodAll()
    {
        $entity = Yii::app()->request->getPost('entity');
        $userId = Yii::app()->request->getPost('userId');
        $success = AntispamCheck::changeStatusAll($entity, $userId, AntispamCheck::STATUS_UNDEFINED, AntispamCheck::STATUS_GOOD);
        echo CJSON::encode(array('success' => $success));
    }

    /**
     * Кнопка "Хорошо"
     * @todo Убрать костыль с refresh
     */
    public function actionMark()
    {
        $checkId = Yii::app()->request->getPost('checkId');
        $status = Yii::app()->request->getPost('status');
        $check = AntispamCheck::model()->findByPk($checkId);
        $success = $check->changeStatus($status);
        $check->refresh();
        echo CJSON::encode(array('success' => $success, 'check' => $check->toJson()));
    }
}