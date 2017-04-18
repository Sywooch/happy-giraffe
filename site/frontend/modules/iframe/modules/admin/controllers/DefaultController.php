<?php

namespace site\frontend\modules\iframe\modules\admin\controllers;

use site\frontend\modules\iframe\modules\admin\models\FramePartners;
use site\frontend\modules\iframe\components\QaController;

/*
 * Управление партнерами iframe
 */
class DefaultController extends QaController
{
    public $litePackage = 'pediatrician-iframe';
    public $layout = 'main';

    public function actionIndex()
    {
        $model = new FramePartners();
        $this->render('index',['model'=>$model]);
    }

    public function actionCreate($url,$type)
    {
        $model = new FramePartners();
        $model->description = $url;
        $model->type = $type;
        $model->key = md5($url);
        if($model->save()) {
            return $this->redirect(['index']);
        }
        return false;
    }

    public function actionDelete($id)
    {
        $model = FramePartners::model()->findByPk($id);
        $model->delete();
        return $this->redirect(['index']);
    }
    public function actionViewCode($id)
    {
        $model = FramePartners::model()->findByPk($id);
        $this->render('view-code',['model'=>$model]);
    }
}