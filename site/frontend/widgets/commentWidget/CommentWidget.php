<?php

class CommentWidget extends CWidget
{
	public $onlyList = FALSE;
	public $model;
    public $entity;
	public $entity_id;

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
		$data_provider = $comment_model->get($this->entity, $this->entity_id);
        // Если комментарии поста - считаем рейтинг
        if($this->entity == 'CommunityContent')
        {
            Rating::model()->saveByEntity(CommunityContent::model()->findByPk($this->entity_id), 'cm', floor($data_provider->itemCount / 10));
        }
        $this->registerScripts();
		if ($this->onlyList)
		{
			$this->render('list', array(
				'dataProvider' => $data_provider,
			));
		}
		else
		{
			$this->render('form', array(
				'comment_model' => $comment_model,
				'dataProvider' => $data_provider,
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