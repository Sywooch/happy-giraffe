<?php

class CommentWidget extends CWidget
{
	
	public $onlyList = FALSE;
	public $model;
	public $object_id;
	
	public function run()
	{
		$comment_model = Comment::model();
		$data_provider = $comment_model->get($this->model, $this->object_id);
		if ($this->onlyList)
		{
			$this->render('list', array(
				'comments' => $data_provider->data,
				'total' => $data_provider->totalItemCount,
				'pages' => $data_provider->pagination,
			));
		}
		else
		{
			$this->render('form', array(
				'model' => $this->model,
				'object_id' => $this->object_id,
				'comment_model' => $comment_model,
				'data_provider' => $data_provider,
			));
		}
	}	
	
}