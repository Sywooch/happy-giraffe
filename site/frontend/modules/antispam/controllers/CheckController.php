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
     */
    public function actionMarkGood()
    {
        $this->changeStatus(AntispamCheck::STATUS_GOOD);
    }

    /**
     * Кнопка "Плохо"
     */
    public function actionMarkBad()
    {
        $this->changeStatus(AntispamCheck::STATUS_BAD);
    }

    /**
     * Кнопка "Под вопросом"
     */
    public function actionMarkQuestionable()
    {
        $this->changeStatus(AntispamCheck::STATUS_QUESTIONABLE);
    }

    /**
     * Кнопка "Отмена"
     */
    public function actionMarkUndefined()
    {
        $this->changeStatus(AntispamCheck::STATUS_UNDEFINED);
    }

    /**
     * Смена статуса
     *
     * @param $newStatus
     */
    protected function changeStatus($newStatus)
    {
        $checkId = Yii::app()->request->getPost('checkId');
        $check = AntispamCheck::model()->findByPk($checkId);
        $success = $check->changeStatus($newStatus);
        echo CJSON::encode(array('success' => $success));
    }
}