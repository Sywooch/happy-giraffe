<?php

class ForumsController extends ELController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionExecuted(){
        $this->render('executed');
    }

    public function actionReports($page = 0){
        $model = new ELLink();

        $dataProvider = $model->search();
        $criteria = $dataProvider->criteria;
        $criteria->with = array('site'=>array(
            'select'=>array('type')
        ));
        $criteria->compare('site.type', ELSite::TYPE_FORUM);
        $count = ELLink::model()->count($dataProvider->criteria);

        $pages = new CPagination($count);
        $pages->currentPage = $page;
        $pages->applyLimit($dataProvider->criteria);

        $models = ELLink::model()->findAll($criteria);

        $this->render('reports', compact('models', 'pages'));
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