<?php
class FileUploadWidget extends CWidget
{
    protected $input_id;
    public $album_id;
    public $mode = 'full';

    public function form($init = true)
    {
        parent::init();
        $this->registerScripts();
        if($this->mode == 'full')
            $this->render('index', array('init' => $init));
        elseif($this->mode == 'attach')
            $this->render('attach', array('init' => $init));
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

        $js = "var upload_ajax_url = '" . Yii::app()->createUrl('/albums/addPhoto', array('a' => $this->album_id)) . "';
        var upload_base_url = '" . $baseUrl . "';";
        if($this->album_id)
            $js .= "Album.album_id = " . $this->album_id . ";";

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery')
            ->registerScript('upload_ajax_url', $js, CClientScript::POS_HEAD);
    }

    public function loadScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerCoreScript('jquery')
            ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/album.js')
            ->registerScriptFile($baseUrl . '/' . 'swfupload.js')
            ->registerScriptFile($baseUrl . '/' . 'jquery.swfupload.js')
            ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/scrollbarpaper.js');
    }
}
