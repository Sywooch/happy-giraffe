<?php

class HController extends CController
{
	public $menu=array();
	public $breadcrumbs=array();


    public function beforeAction($action)
    {
        if (in_array(Yii::app()->user->id, array(10186, 10127, 12678, 10229, 12980))){
            Yii::app()->user->logout(true);
            $this->redirect('/');
        }

        return parent::beforeAction($action);
    }

    public function getViews()
    {
        $path = '/' . Yii::app()->request->pathInfo . '/';
        $model = PageView::model()->findByPath($path);
        if($model)
            $views = $model->views + 1;
        else
            $views = 1;

        if(!$model || (time() - 1800 > $model->updated))
        {
            $js = '$.post(
                    "' . $this->createUrl('/ajax/pageView') . '",
                    {path : "' . $path . '"},
                    function(data) {
                        $("#page_views").text(data.count);
                    },
                    "json"
                );';
            Yii::app()->clientScript->registerScript('update_page_view', $js, CClientScript::POS_LOAD);
        }
        return $views;
    }
}