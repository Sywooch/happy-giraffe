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

    public function window($view_type, $a = false)
    {
        if($view_type == 'window')
            $this->render('window');
        elseif($view_type == 'browse')
            $this->render('_browse');
        elseif($view_type == 'albums')
        {
            if($a)
                $model = Album::model()->findByPk($a);
            else
                $model = Album::model()->find(array(
                    'condition' => 'author_id = :author_id',
                    'params' => array(':author_id' => Yii::app()->user->id),
                    'limit' => 1,
                ));
            $albums = Album::model()->findByUser(Yii::app()->user->id);
            $this->render('_albums', array(
                'model' => $model,
                'albums' => $albums,
            ));
        }
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

        $path = Yii::getPathOfAlias('zii.widgets.assets.listview');
        $assets = Yii::app()->assetManager->publish($path);
        $cs->registerScriptFile($assets.'/jquery.yiilistview.js');

        $cs->registerCoreScript('bbq');
        $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget');
        $file_upload->loadScripts();
        $this->endWidget();
    }
}
