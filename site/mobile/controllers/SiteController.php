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

        $this->pageTitle = $data->title . ' - Комментарии';
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

    public function actionSearch($text = false, $index = false)
    {
        if (!empty($text)) {
            $index = $index ? $index : 'community';
            $pages = new CPagination();
            $pages->pageSize = 100000;
            $criteria = new stdClass();
            $criteria->from = $index;
            $criteria->select = '*';
            $criteria->paginator = $pages;
            $criteria->query = $text;
            $resIterator = Yii::app()->search->search($criteria);

            $allSearch = $textSearch = Yii::app()->search->select('*')->from('community')->where($criteria->query)->limit(0, 100000)->searchRaw();
            $allCount = count($allSearch['matches']);

            $textSearch = Yii::app()->search->select('*')->from('communityText')->where($criteria->query)->limit(0, 100000)->searchRaw();
            $textCount = count($textSearch['matches']);

            $videoSearch = Yii::app()->search->select('*')->from('communityVideo')->where($criteria->query)->limit(0, 100000)->searchRaw();
            $videoCount = count($videoSearch['matches']);

            $criteria = new CDbCriteria;
            $criteria->with = array('travel', 'video', 'post');

            $dp = new CArrayDataProvider($resIterator->getRawData(), array(
                'keyField' => 'id',
            ));

            $viewData = compact('dp', 'criteria', 'index', 'text', 'allCount', 'textCount', 'videoCount', 'travelCount');
        } else
            $viewData = array('dp'=>null, 'criteria'=>null, 'index'=>$index, 'text'=>'', 'allCount'=>0, 'textCount'=>0, 'videoCount'=>0, 'travelCount'=>0);

        $this->pageTitle = 'Поиск по сайту Веселый Жираф';
        $this->render('search', $viewData);
    }
}
