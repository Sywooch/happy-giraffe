<?php
/**
 * Author: alexk984
 * Date: 11.06.12
 */
class ParsingController extends SController
{
    public $layout = '//layouts/empty';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }
    public function actionIndex(){
        $this->render('index');
    }

    public function actionProxy()
    {
        Proxy::model()->deleteAll();
        $proxyList = Yii::app()->request->getPost('proxy');
        $proxyList = explode("\n", $proxyList);
        foreach ($proxyList as $proxy) {
            $model = new Proxy();
            $model->value = $proxy;
            $model->save();
        }

        echo CJSON::encode(array('status' => true));
    }

    public function actionStopThreads()
    {
        Config::setAttribute('stop_threads', 1);
        echo CJSON::encode(array('status' => true));
    }

    public function actionSetConfigAttribute(){
        Config::setAttribute(Yii::app()->request->getPost('title'), Yii::app()->request->getPost('value'));
        echo CJSON::encode(array('status' => true));
    }
}
