<?php
class ReportWidget extends CWidget
{

    public $entity;
    public $entity_id;
    public $model = null;

    public function init()
    {
        if($this->model)
        {
            $this->entity = get_class($this->model);
            $this->entity_id = $this->model->primaryKey;
        }
    }

    public function button($selector)
    {
        if(Yii::app()->user->isGuest)
            return false;
        if(!Yii::app()->request->isAjaxRequest)
            $this->registerScripts();
        $this->render('button', array(
            'selector' => $selector,
        ));
    }

    public function form()
    {
        $report = new Report;
        $this->render('form', array(
            'report' => $report,
            'source_data' => array(
                'entity' => $this->entity,
                'entity_id' => $this->entity_id,
            ),
        ));
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

        $js = 'Report.url = "' . Yii::app()->createUrl('/ajax/showreport/') . '"';

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery')
            ->registerScriptFile($baseUrl . '/report.js')
            ->registerScript('report_url', $js, CClientScript::POS_READY);
    }
}