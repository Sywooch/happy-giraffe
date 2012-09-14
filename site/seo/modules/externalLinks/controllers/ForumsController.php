<?php

class ForumsController extends ELController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionTasks(){

    }

    public function actionExecuted(){

    }

    public function actionReports(){

    }

    public function actionAdd()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null) {
            $model = new ELSite;
            $model->url = $host;
            $model->type = ELSite::TYPE_FORUM;
            if ($model->save()) {
                $response = array(
                    'status' => true,
                    'id' => $model->id
                );
            } else
                $response = array('status' => false);
        } else{
            $model->url = $host;
            $model->type = ELSite::TYPE_FORUM;
            $model->status = ELSite::STATUS_NORMAL;
            if ($model->save()) {
                $response = array(
                    'status' => true,
                    'id' => $model->id
                );
            } else
                $response = array('status' => false);
        }

        echo CJSON::encode($response);
    }
}