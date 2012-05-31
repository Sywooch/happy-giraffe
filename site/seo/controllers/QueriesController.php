<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class QueriesController extends SController
{
    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionParse()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();

        $response = array(
            'status' => true,
            'count' => Queries::model()->count()
        );

        echo CJSON::encode($response);
    }

    public function actionSearch(){
        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE);
        $parser->start();
    }

    public function actionProxy()
    {
        Proxy::model()->deleteAll();
        $proxyList = Yii::app()->request->getPost('proxy');
        $proxyList = explode("\n", $proxyList);
        foreach($proxyList as $proxy){
            $model = new Proxy();
            $model->value = $proxy;
            $model->save();
        }

        echo CJSON::encode(array('status' => true));
    }
}
