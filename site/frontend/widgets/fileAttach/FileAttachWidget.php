<?php
class FileAttachWidget extends CWidget
{
    public $model;
    public $entity;
    public $entity_id;

    public function init()
    {
        parent::init();
        if($this->model)
        {
            $this->entity = get_class($this->model);
            $this->entity_id = $this->model->primaryKey;
        }
    }

    public function button()
    {
        $this->registerScripts();
        $this->render('button');
    }

    public function window($view_type = 'browse')
    {
        $this->render('window', array(
            'view_type' => $view_type
        ));
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($baseUrl . '/attaches.js', CClientScript::POS_HEAD);
        $cs->registerScript('attaches_entity', '
            Attach.entity = "' . $this->entity . '";
            Attach.entity_id = "' . $this->entity_id. '";
            Attach.base_url = "' . Yii::app()->createUrl('/albums/album/saveAttach') . '"
        ');

        $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget');
        $file_upload->loadScripts();
        $this->endWidget();
    }
}
