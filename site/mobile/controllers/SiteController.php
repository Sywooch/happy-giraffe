<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/4/13
 * Time: 4:16 PM
 * To change this template use File | Settings | File Templates.
 */
class SiteController extends MController
{
    public function init()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        parent::init();
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionComments($entity, $entity_id)
    {
        $data = CActiveRecord::model($entity)->findByPk($entity_id);
        $comments = Comment::model()->get($entity, $entity_id, 'default', 10);

        $this->render('comments', compact('data', 'comments', 'linkText', 'linkUrl'));
    }

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
            {
                if(file_exists(Yii::getPathOfAlias('application.views.system.' . $error['code']) . '.php'))
                {
                    $this->layout = '//system/layout';
                    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/common.css');
                    $this->render('//system/' . $error['code'], $error);
                }
                else
                    $this->render('error', $error);
            }
        }
    }
}
