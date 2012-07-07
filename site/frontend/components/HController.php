<?php

class HController extends CController
{
	public $menu=array();
	public $breadcrumbs=array();
    public $rssFeed = null;
    public $seoHrefs = array();
    public $seoContent = array();
    public $registerUserModel = null;
    public $registerUserData = null;

    public function invalidActionParams($action)
    {
        throw new CHttpException(404, Yii::t('yii', 'Your request is invalid.'));
    }

    protected function beforeAction($action)
    {
        if (in_array($this->uniqueId, array(
            'blog',
            'community',
            'services/horoscope/default',
            'services/childrenDiseases/default',
            'cook/spices',
            'cook/choose',
        )) || in_array($this->route, array('cook/recipe/view'))  || in_array($this->route, array('cook/recipe/index'))) {
            $reflector = new ReflectionClass($this);
            $parametersObjects = $reflector->getMethod('action' . $this->action->id)->getParameters();
            $parametersNames = array();
            foreach ($parametersObjects as $p)
                $parametersNames[] = $p->name;
            foreach ($this->actionParams as $p => $v)
                if (array_search($p, $parametersNames) === false && strpos($p, '_page') === false)
                    throw new CHttpException(404, 'Такой записи не существует');
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