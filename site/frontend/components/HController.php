<?php

class HController extends CController
{
    public $menu = array();
    public $breadcrumbs = array();
    public $rssFeed = null;
    public $seoHrefs = array();
    public $seoContent = array();

    public $meta_description = null;
    public $meta_keywords = null;
    public $meta_title = null;
    public $page_meta_model = null;

    protected function beforeAction($action)
    {
        //разлогинивемя забаненых юзеров - временно
        if (in_array(Yii::app()->user->id, array(10186, 10127, 12678, 10229, 12980))) {
            Yii::app()->user->logout(true);
            $this->redirect('/');
        }
        $this->setMetaTags();

        return parent::beforeAction($action);
    }

    protected function afterRender($view, &$output)
    {
        $js = "
            $(function() {
                var seoHrefs = " . CJSON::encode($this->seoHrefs) . ";
                var seoContent = " . CJSON::encode($this->seoContent) . ";
                $('[hashString]').each(function(){
                    var key = $(this).attr('hashString');
                    if($(this).attr('hashType') == 'href'){
                        $(this).attr('href', Base64.decode(seoHrefs[key]));
                    }else{
                        $(this).replaceWith(Base64.decode(seoContent[key]));
                    }
                });


            });
        ";

        Yii::app()->clientScript->registerScript('seoHrefs', $js, CClientScript::POS_END);

        return parent::afterRender($view, $output);
    }

    public function getViews()
    {
        $path = '/' . Yii::app()->request->pathInfo . '/';
        $model = PageView::model()->findByPath($path);
        if ($model)
            $views = $model->views + 1;
        else
            $views = 1;

        if (!$model || (time() - 1800 > $model->updated)) {
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

    public function setMetaTags()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->page_meta_model = PageMetaTag::getModel(Yii::app()->controller->route, Yii::app()->controller->actionParams);
            if ($this->page_meta_model !== null) {
                if (!empty($this->page_meta_model->description))
                    $this->meta_description = $this->page_meta_model->description;
                if (!empty($this->page_meta_model->keywords))
                    $this->meta_keywords = $this->page_meta_model->keywords;
                if (!empty($this->page_meta_model->title))
                    $this->meta_title = $this->page_meta_model->title;
            }
        }
    }
}