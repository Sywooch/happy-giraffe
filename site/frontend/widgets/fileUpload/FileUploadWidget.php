<?php
class FileUploadWidget extends CWidget
{
    protected $input_id;

    public function init()
    {
        parent::init();
        $this->registerScripts();
        $this->render('index');
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

        $js = "var upload_ajax_url = '" . Yii::app()->createUrl('/ajax/savePhoto') . "';
        var upload_base_url = '" . Yii::app()->baseUrl . "'";

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery')
            ->registerScript('upload_ajax_url', $js, CClientScript::POS_HEAD)
            ->registerScriptFile($baseUrl . '/' . 'swfupload.js')
            ->registerScriptFile($baseUrl . '/' . 'jquery.swfupload.js')

            ->registerScriptFile($baseUrl . '/' . 'html5upload.js')
            ->registerScriptFile($baseUrl . '/' . 'file_upload.js')
            ->registerCssFile($baseUrl . '/' . 'file_upload.css')
            /* ->registerScriptFile($baseUrl . '/' . 'swfupload.queue.js')
            ->registerScriptFile($baseUrl . '/' . 'fileprogress.js')
            ->registerScriptFile($baseUrl . '/' . 'swfupload.handlers.js')
            ->registerScript('init_swf_upload', $swfupload, CClientScript::POS_HEAD)*/
        ;
    }
}
