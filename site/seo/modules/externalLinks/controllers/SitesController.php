<?php

class SitesController extends SController
{
    public $layout = '/layouts/externalLinks';
    public $icon = 2;
    public $pageTitle = 'Внешние ссылки';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionReports()
    {
        $this->render('reports');
    }

    public function actionCheckSite()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null)
            $response = array(
                'type' => 1,
            );
        else{
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

    public function actionAddToBlacklist(){
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null){
            $model = new ELSite();
            $model->status = ELSite::STATUS_BLACKLIST;
            $model->save();
        }
        else{
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
}