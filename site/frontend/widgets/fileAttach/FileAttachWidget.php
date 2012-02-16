<?php
class FileAttachWidget extends CWidget
{
    public $model;
    public $model_name;
    public $model_id;

    public function init()
    {
        parent::init();
        if(!$this->model_name)
        {
            $this->model_name = get_class($this->model);
            $this->model_id = $this->model->primaryKey;
        }
        $this->registerScripts();
        $this->render('index');
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($baseUrl . '/attaches.js', CClientScript::POS_HEAD);
        $cs->registerScript('attaches_entity', '
            Attach.entity = "' . $this->model_name . '";
            Attach.entity_id = "' . $this->model_id . '";
            Attach.base_url = "' . Yii::app()->createUrl('/albums/album/saveAttach') . '"
        ');
    }
}
