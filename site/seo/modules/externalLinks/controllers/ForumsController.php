<?php

class ForumsController extends ELController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionExecuted()
    {
        $this->render('executed');
    }

    public function actionReports($page = 1)
    {
        $model = new ELLink();

        $dataProvider = $model->search();
        $criteria = $dataProvider->criteria;
        $criteria->with = array('site' => array(
            'select' => array('type')
        ));
        $criteria->condition = 'site.type = '. ELSite::TYPE_FORUM.' AND link_cost IS NULL';
        $count = ELLink::model()->count($dataProvider->criteria);

        $pages = new CPagination($count);
        $pages->currentPage = $page - 1;
        $pages->applyLimit($dataProvider->criteria);

        $models = ELLink::model()->findAll($criteria);

        $this->render('reports', compact('models', 'pages'));
    }

    public function actionAdd()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];
        $create_task = Yii::app()->request->getPost('create_task');

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null) {
            $model = new ELSite;
            $model->url = $host;
            $model->type = ELSite::TYPE_FORUM;
            if ($model->save()) {
                if ($create_task)
                    ELTask::createRegisterTask($model->id);

                if ($model->status == ELSite::STATUS_BLACKLIST)
                    $type = 3;
                elseif (!empty($model->links))
                    $type = 2;
                else
                    $type = 1;

                $response = array(
                    'status' => true,
                    'id' => $model->id,
                    'type' => $type,
                    'account' => $this->renderPartial('_reg_data', array('account' => $model->account), true)
                );
            } else
                $response = array('status' => false);
        } else {
            $model->url = $host;
            $model->type = ELSite::TYPE_FORUM;
            if ($model->save()) {

                if ($model->status == ELSite::STATUS_BLACKLIST)
                    $type = 3;
                elseif (!empty($model->tasks))
                    $type = 2;
                else
                    $type = 1;

                $response = array(
                    'status' => true,
                    'id' => $model->id,
                    'type' => $type,
                    'account' => $this->renderPartial('_reg_data', array('account' => $model->account), true)
                );
            } else
                $response = array('status' => false);
        }

        echo CJSON::encode($response);
    }

    public function actionCheck()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null)
            $response = array(
                'type' => 1,
            );
        else {
            if ($model->status == ELSite::STATUS_BLACKLIST)
                $response = array(
                    'type' => 3,
                );
            else
                $response = array(
                    'type' => 2,
                );
        }

        echo CJSON::encode($response);
    }

    public function actionTest(){
        $models = ELTask::model()->getRegisterTasks();
        echo count($models).' register tasks<br>';
        echo ELTask::model()->todayPostTaskCount(). ' - ' . ELTask::model()->todayRegisterTaskCount()
            . ' - ' .ELTask::model()->getTaskLimit();
    }
}