<?php

class DefaultController extends HController
{
    public function actionLive($entity)
    {

    }

    public function actionRemoved($entity)
    {

    }

    public function actionQuestionable($entity)
    {

    }

    public function actionAnalysis($userId, $checkId)
    {

    }

    public function actionMarkGoodAll()
    {
        $entity = Yii::app()->request->getPost('entity');
        $userId = Yii::app()->request->getPost('userId');
        $success = AntispamCheck::changeStatusAll($entity, $userId, AntispamCheck::STATUS_UNDEFINED, AntispamCheck::STATUS_GOOD);
        echo CJSON::encode(array('success' => $success));
    }

    public function actionMarkGood()
    {
        $this->changeStatus(AntispamCheck::STATUS_GOOD);
    }

    public function actionMarkBad()
    {
        $this->changeStatus(AntispamCheck::STATUS_BAD);
    }

    public function actionMarkQuestionable()
    {
        $this->changeStatus(AntispamCheck::STATUS_QUESTIONABLE);
    }

    public function actionMarkPending()
    {
        $this->changeStatus(AntispamCheck::STATUS_PENDING);
    }

    public function actionMarkUndefined()
    {
        $this->changeStatus(AntispamCheck::STATUS_UNDEFINED);
    }

    protected function changeStatus($newStatus)
    {
        $checkId = Yii::app()->request->getPost('checkId');
        $check = AntispamCheck::model()->findByPk($checkId);
        $success = $check->changeStatus($newStatus);
        echo CJSON::encode(array('success' => $success));
    }
}