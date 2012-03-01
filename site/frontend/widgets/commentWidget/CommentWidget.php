<?php

class CommentWidget extends CWidget
{
	public $onlyList = FALSE;
	public $model;
    public $entity;
	public $entity_id;
    public $title = 'Комментарии';

    public function init()
    {
        if($this->model)
        {
            $this->entity = get_class($this->model);
            $this->entity_id = $this->model->primaryKey;
        }
    }
	
	public function run()
	{
		$comment_model = Comment::model();
        $dataProvider = $comment_model->get($this->entity, $this->entity_id);
        $dataProvider->getData();
        if(isset($_GET['lastPage']))
        {
            $dataProvider->pagination->currentPage = $dataProvider->pagination->pageCount;
            $dataProvider->data = null;
            unset($_GET['lastPage']);
        }
        // Если комментарии поста - считаем рейтинг
        if($this->entity == 'CommunityContent')
        {
            Rating::model()->saveByEntity(CommunityContent::model()->findByPk($this->entity_id), 'cm', floor($dataProvider->itemCount / 10));
        }
        $this->registerScripts();
		if ($this->onlyList)
		{
			$this->render('list', array(
				'dataProvider' => $dataProvider,
			));
		}
		else
		{
			$this->render('form', array(
				'comment_model' => $comment_model,
				'dataProvider' => $dataProvider,
			));
		}
	}

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/comment.js');
    }
}