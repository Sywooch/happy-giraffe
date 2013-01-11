<?php

class CommentWidget extends CWidget
{
    /**
     * @var bool
     * Отключает возможность комментирования
     */
    public $onlyList = FALSE;

    /**
     * @var HActiveRecord
     * ActiveRecord model
     */
    public $model;

    /**
     * @var string
     * Название класса модели
     */
    public $entity;

    /**
     * @var int
     * Primary key модели
     */
    public $entity_id;
    public $title = 'Комментарии';
    public $actions = true;
    public $button = 'Добавить комментарий';
    public $type = 'default';
    public $readOnly = false;
    public $registerScripts = false;
    public $popUp = false;
    public $commentModel  = 'Comment';
    public $photoContainer = false;

    /**
     * @var bool
     * Имя созданного js объекта
     */
    protected $objectName = false;

    /**
     * @var bool
     * Включает голосование
     */
    public $vote = false;

    public function init()
    {
        if($this->model)
        {
            $this->entity = get_class($this->model);
            $this->entity_id = $this->model->primaryKey;
        } elseif($this->entity) {
            $model = call_user_func(array($this->entity, 'model'));
            $this->model = $model->findByPk($this->entity_id);
        }
        if($this->vote)
            $this->commentModel = 'CommentProduct';
    }

	public function run()
	{
        if($this->registerScripts)
        {
            $this->registerScripts();
            return;
        }

        $comment_model = call_user_func(array($this->commentModel, 'model'));

        $dataProvider = $comment_model->get($this->entity, $this->entity_id, $this->type);
        $dataProvider->getData();
        if(isset($_GET['lastPage']))
        {
            $dataProvider->pagination->currentPage = $dataProvider->pagination->pageCount;
            $dataProvider->data = null;
            unset($_GET['lastPage']);
        }

        if($this->entity != 'ContestWork')
        {
            Rating::model()->saveByEntity($this->model, 'cm', floor($dataProvider->itemCount / 10));
        }

        $this->registerScripts();
		if ($this->onlyList)
		{
			$this->render('list', array(
				'dataProvider' => $dataProvider,
                'type'=>$this->type,
			));
		}
		else
		{
			$this->render('new_form', array(
				'comment_model' => $comment_model,
				'dataProvider' => $dataProvider,
                'type'=>$this->type,
			));
		}
	}

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/comment.js', CClientScript::POS_HEAD)
        ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.tmpl.min.js');

        if(!$this->registerScripts)
        {
            $this->id = $this->entity . $this->entity_id;
            $this->objectName = 'comment_' . $this->id;
            if ($this->photoContainer && Yii::app()->request->isAjaxRequest)
                $scroll_container = '#photo-window';
            else
                $scroll_container = '.layout-container';

            $script = '
            var ' . $this->objectName . ' = new Comment;
            ' . $this->objectName . '.setParams(' . CJavaScript::encode(array(
                'entity' => $this->entity,
                'entity_id' => (int)$this->entity_id,
                'save_url' => Yii::app()->createUrl('ajax/sendcomment'),
                'toolbar' => $this->type == 'guestBook' ? 'Simple' : 'Chat',
                'model' => $this->commentModel,
                'object_name' => $this->objectName,
                'scrollContainer'=>$scroll_container
            )) . ');';
            echo '<script type="text/javascript">' . $script . '</script>';
            Yii::app()->clientScript->registerScriptFile('/javascripts/history.js');
        }

        if(!$this->onlyList)
        {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/ckeditor/ckeditor.js?2')
                ->registerScriptFile(Yii::app()->baseUrl . '/ckeditor/adapters/jquery.js');
        }

        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => new $this->commentModel,
            'id' => 'attach' . $this->commentModel . 'comment',
        ));
        $fileAttach->registerScripts();
        $this->endWidget();

        if (Yii::app()->user->getState('redirect_type') == 'comment'){
            Yii::app()->clientScript->registerScript('redirect_to_comment','gotoComment();');
            Yii::app()->user->setState('redirect_type', null);
        }
    }
}