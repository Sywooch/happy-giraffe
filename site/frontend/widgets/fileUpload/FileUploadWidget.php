<?php
class FileUploadWidget extends CWidget
{
    protected $input_id;

    public function form()
    {
        parent::init();
        $this->registerScripts();
        $this->render('index');
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

        $js = "var upload_ajax_url = '" . Yii::app()->createUrl('/ajax/imageUpload') . "';
        var upload_base_url = '" . $baseUrl . "'";

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery')
            ->registerScript('upload_ajax_url', $js, CClientScript::POS_HEAD)
            ->registerScriptFile($baseUrl . '/' . 'file_upload.js')
            ->registerCssFile($baseUrl . '/' . 'file_upload.css');
    }

    public function loadScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerCoreScript('jquery')
            ->registerScriptFile($baseUrl . '/' . 'swfupload.js')
            ->registerScriptFile($baseUrl . '/' . 'jquery.swfupload.js');
    }
}
