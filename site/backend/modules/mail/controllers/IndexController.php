<?php
/**
 * User: Eugene Podosenov
 * Date: 15.06.12
 */
class IndexController extends BController
{
    public $layout = '//layouts/club';
    public $defaultAction='index';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionCreate()
    {
        $model = new MailCampaign;
        $model->author_id = Yii::app()->user->id;
        if(Yii::app()->request->getPost('subject') && Yii::app()->request->getPost('body'))
        {
            Yii::app()->mc->sendToGroup(Yii::app()->request->getPost('subject'), Yii::app()->request->getPost('body'));
        }
        $this->render('create', compact('model'));
    }
}
