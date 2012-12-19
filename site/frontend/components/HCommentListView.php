<?php
/**
 * User: Eugene
 * Date: 05.06.12
 */
Yii::import('zii.widgets.CListView');
class HCommentListView extends CListView
{
    public $ajaxState = true;
    /**
     * @var bool
     * Сообщает, в попапе ли был открыт ListView
     */
    public $popUp = false;

    public function init()
    {
        $this->emptyText = '';
        if($this->ajaxState === true)
            $this->registerStatePagination();
        parent::init();
    }

    public function registerClientScript()
    {
        $id=$this->getId();

        if($this->ajaxUpdate===false)
            $ajaxUpdate=array();
        else
            $ajaxUpdate=array_unique(preg_split('/\s*,\s*/',$this->ajaxUpdate.','.$id,-1,PREG_SPLIT_NO_EMPTY));
        $options=array(
            'ajaxUpdate'=>$ajaxUpdate,
            'ajaxVar'=>$this->ajaxVar,
            'pagerClass'=>$this->pagerCssClass,
            'loadingClass'=>$this->loadingCssClass,
            'sorterClass'=>$this->sorterCssClass,
        );
        if($this->ajaxUrl!==null)
            $options['url']=CHtml::normalizeUrl($this->ajaxUrl);
        if($this->updateSelector!==null)
            $options['updateSelector']=$this->updateSelector;
        if($this->beforeAjaxUpdate!==null)
            $options['beforeAjaxUpdate']=(strpos($this->beforeAjaxUpdate,'js:')!==0 ? 'js:' : '').$this->beforeAjaxUpdate;
        if($this->afterAjaxUpdate!==null)
            $options['afterAjaxUpdate']=(strpos($this->afterAjaxUpdate,'js:')!==0 ? 'js:' : '').$this->afterAjaxUpdate;

        $options=CJavaScript::encode($options);
        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('bbq');
        if(!$this->popUp)
        {
            $cs->registerScriptFile($this->baseScriptUrl.'/jquery.yiilistview.js',CClientScript::POS_END);
            $cs->registerScript(__CLASS__.'#'.$id,"jQuery('#$id').yiiListView($options);");
        }
        else
        {
            echo '<script type="text/javascript">$(function() {jQuery(\'#' . $id . '\').yiiListView(' . $options . ');});</script>';
        }
    }

    protected function registerStatePagination()
    {
        if(!$this->popUp)
        {
            $js = 'var history_' . $this->id . ' = new AjaxHistory("' .$this->id  . '");';
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/history.js')
                ->registerScript('history_' . $this->id, $js, CClientScript::POS_END);
            $ajaxUpdate = null;
            if($this->afterAjaxUpdate)
                $ajaxUpdate = $this->afterAjaxUpdate;
            $this->afterAjaxUpdate = 'function(id, data) {
            '.($ajaxUpdate ? $ajaxUpdate : '').'
                history_' . $this->id . '.changeBrowserUrl($.fn.yiiListView.getUrl(id));
            }';
        }
        else
        {
            $this->afterAjaxUpdate = 'function(id, data) {}';
        }
    }
}
