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

    public function actionAddToBlacklist()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null) {
            $model = new ELSite();
            $model->url = $host;
            $model->status = ELSite::STATUS_BLACKLIST;
            $model->type = 1;
        } else {
            if ($model->status == ELSite::STATUS_BLACKLIST) {
                echo CJSON::encode(array('status' => true));
                Yii::app()->end();
            } else
                $model->status = ELSite::STATUS_BLACKLIST;
        }

        if ($model->save()) {
            $response = array('status' => true);
        } else
            $response = array(
                'status' => false,
                'error' => $model->getErrorsText()
            );

        echo CJSON::encode($response);
    }

    public function actionAdd()
    {

    }
}