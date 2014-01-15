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

    public function actionMarkGood($checkId)
    {
        $this->changeStatus($checkId, AntispamCheck::STATUS_GOOD);
    }

    public function actionMarkDelete($checkId)
    {
        $this->changeStatus($checkId, AntispamCheck::STATUS_BAD);
    }

    public function actionMarkQuestionable($checkId)
    {
        $this->changeStatus($checkId, AntispamCheck::STATUS_QUESTIONABLE);
    }

    public function actionMarkPending($checkId)
    {
        $this->changeStatus($checkId, AntispamCheck::STATUS_PENDING);
    }

    protected function changeStatus($checkId, $newStatus)
    {
        $check = AntispamCheck::model()->findByPk($checkId);
        $success = $check->changeStatus($newStatus);
        echo CJSON::encode(array('success' => $success));
    }
}