<?php
class FileAttachWidget extends CWidget
{
    public $model;
    public $entity;
    public $entity_id;
    public $container;
    public $afterSelect;
    public $disableNavigation = false;
    public $customButton = false;
    public $customButtonHtmlOptions = array();
    public $button_title = 'Фото';

    public $title;
    public $first_button_title = 'Загрузить фото';
    public $first_button_class = 'btn-orange';
    public $many = false;

    public function init()
    {
        parent::init();
        if($this->model)
        {
            $this->entity = get_class($this->model);
            $this->entity_id = $this->model->primaryKey;
        }
        if(mb_strstr($this->id, 'yw'))
            $this->id = 'attach' . $this->entity . $this->entity_id;

        if ($this->customButton) {
            $htmlOptions = (Yii::app()->user->isGuest) ?
                array(
                    'href' => '#login',
                    'class' => 'fancy',
                    'data-theme'=>"white-square"
                )
                :
                array(
                    'href' => Yii::app()->createUrl('/albums/attach', array('entity' => $this->entity, 'entity_id' => $this->entity_id)),
                    'class' => 'fancy attach',
                    'onclick'=>$this->id . '.updateEntity(\''.$this->entity.'\', \''.$this->entity_id.'\');',
            );
            echo CHtml::openTag('a', CMap::mergeArray($htmlOptions, $this->customButtonHtmlOptions));
            $this->registerScripts();
        }
    }

    public function run()
    {
        if ($this->customButton) {
            echo CHtml::closeTag('a');
        }
    }

    public function button()
    {
        $this->registerScripts();
        $this->render('button');
    }

    public function window($view_type, $a = false)
    {
        if($this->entity == 'Contest')
        {
            $this->title = 'Фотография для конкурса';
            $this->button_title = 'Добавить на конкурс';
        }
        elseif($this->entity == 'User')
        {
            $this->title = 'Главное фото';
            $this->button_title = 'Выбор';
        }
        elseif($this->entity == 'PhotoComment')
        {
            $this->title = 'Отправить фото в гостевую';
            $this->button_title = 'Продолжить';
        }
        elseif($this->entity == 'CommunityPost' || $this->entity == 'CommunityVideo' || $this->entity == "Comment" || $this->entity == 'Message')
        {
            $this->title = 'Вставить изображение';
            $this->button_title = 'Продолжить';
        }
        elseif($this->entity == 'Product')
        {
            $this->title = 'Добавить фото к продукту';
            $this->button_title = 'Добавить';
        }
        elseif($this->entity == 'Humor')
        {
            $this->title = 'Фото в «Улыбнить вместе с нами»';
            $this->button_title = 'Продолжить';
            $this->disableNavigation = true;
        }
        elseif($this->entity == 'CookRecipe' || $this->entity == 'SimpleRecipe' || $this->entity == 'MultivarkaRecipe')
        {
            $this->title = 'Фото блюда';
            $this->button_title = 'Продолжить';
            $this->disableNavigation = true;
        }
        elseif($this->entity == 'CookDecoration')
        {
            $this->title = 'Загрузка фото в раздел "Оформление блюд"';
            $this->button_title = 'Продолжить';
        }
        elseif($this->entity == 'CommunityContent')
        {
            $this->title = 'Загрузка фото в галерею';
            $this->button_title = 'Продолжить';
            $this->disableNavigation = true;
        }
        elseif($this->entity == 'UserPartner' || $this->entity == 'Baby')
        {
            $this->title = 'Загрузка фото';
            $this->button_title = 'Продолжить';
            $this->many = true;
        }

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
                    'condition' => 'author_id = :author_id and removed = 0',
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
        $cs->registerScriptFile($baseUrl . '/attaches.js?r=32', CClientScript::POS_HEAD)
            ->registerScriptFile($baseUrl . '/jquery.Jcrop.min.js')
            ->registerCssFile($baseUrl . '/jquery.Jcrop.css');
        $cs->registerScript('attaches_entity' . $this->id, '
            var ' . $this->id . ' = new Attach();
            ' . $this->id . '.entity = "' . $this->entity . '";
            ' . $this->id . '.entity_id = "' . $this->entity_id. '";
            ' . $this->id . '.base_url = "' . Yii::app()->createUrl('/albums/album/saveAttach') . '";
            ' . ($this->many ? $this->id . '.many = true;' : '') . '
            ' . $this->id . '.object_name = "' . $this->id . '";
        ', CClientScript::POS_END);

        $path = Yii::getPathOfAlias('zii.widgets.assets.listview');
        $assets = Yii::app()->assetManager->publish($path);
        $cs->registerScriptFile($assets.'/jquery.yiilistview.js');
        $cs->registerCoreScript('bbq');
    }
}
