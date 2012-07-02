<?php

class HController extends CController
{
	public $menu=array();
	public $breadcrumbs=array();
    public $rssFeed = null;
    public $seoHrefs = array();
    public $seoContent = array();

    public function invalidActionParams($action)
    {
        throw new CHttpException(404, Yii::t('yii', 'Your request is invalid.'));
    }

    protected function beforeAction($action)
    {
        if (in_array(Yii::app()->user->id, array(10186, 10127, 12678, 10229, 12980))){
            Yii::app()->user->logout(true);
            $this->redirect('/');
        }

        return parent::beforeAction($action);
    }

    protected function afterRender($view, &$output)
    {
        $js = "$(function() {
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


            });";

        $hash = md5($js);
        $cacheId = 'seoHide_' . $hash;
        Yii::app()->cache->set($cacheId, $js);

        Yii::app()->clientScript->registerScriptFile('/js_dynamics/' . $hash . '.js/', CClientScript::POS_END);

        return parent::afterRender($view, $output);
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