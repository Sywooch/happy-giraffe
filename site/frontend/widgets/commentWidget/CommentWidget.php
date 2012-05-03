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
        } else {
            $model = call_user_func(array($this->entity, 'model'));
            $this->model = $model->findByPk($this->entity_id);
        }
    }

	public function run()
	{
        if(!$this->vote)
		    $comment_model = Comment::model();
        else
            $comment_model = CommentProduct::model();
        $dataProvider = $comment_model->get($this->entity, $this->entity_id);
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
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/ckeditor/ckeditor.js')
                ->registerScriptFile(Yii::app()->baseUrl . '/ckeditor/adapters/jquery.js');
			$this->render('form', array(
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

        $script = 'Comment.setParams(' . CJavaScript::encode(array(
            'entity' => $this->entity,
            'entity_id' => (int)$this->entity_id,
            'save_url' => Yii::app()->createUrl('ajax/sendcomment'),
            'toolbar' => $this->type == 'guestBook' ? 'Simple' : 'Main',
            'model' => $this->vote ? 'CommentProduct' : 'Comment',
        )) . ');';

        Yii::app()->clientScript->registerScript('Comment register script', $script);

        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => new Comment
        ));
        $fileAttach->registerScripts();
        $this->endWidget();
    }
}