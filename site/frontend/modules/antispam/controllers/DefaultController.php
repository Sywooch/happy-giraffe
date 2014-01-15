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

    protected function changeStatus($newStatus)
    {
        $checkId = Yii::app()->request->getPost('checkId');
        $check = AntispamCheck::model()->findByPk($checkId);
        $success = $check->changeStatus($newStatus);
        echo CJSON::encode(array('success' => $success));
    }
}