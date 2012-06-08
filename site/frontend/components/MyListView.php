<?php
Yii::import('zii.widgets.CListView');
class MyListView extends CListView
{
    public $ajaxState = true;
    public $popUp;

    public function init()
    {
        if($this->ajaxState === true)
            $this->registerStatePagination();
        parent::init();
    }

    protected function registerStatePagination()
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
}
