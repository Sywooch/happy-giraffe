<?php

class AjaxController extends Controller
{
	public function actionRate()
	{
		Yii::import('contest.models.*');
		$modelName = $_POST['modelName'];
		$objectId = $_POST['objectId'];
        $social_key = $_POST['key'];
        $value = $_POST['r'];

        $model = $modelName::model()->findByPk($objectId);
        if(!$model)
            Yii::app()->end();

        if($url = Yii::app()->request->getPost('url'))
        {
            Rating::model()->updateByApi($model, $social_key, $url);
        }
        else
        {
            Rating::model()->saveByEntity($model, $social_key, $value, true);
        }

        echo CJSON::encode(array(
            'entity' => Rating::model()->countByEntity($model, $social_key),
            'count' => Rating::model()->countByEntity($model),
        ));
        Yii::app()->end();
	}

	public function actionImageUpload()
	{
		$dir = Yii::getPathOfAlias('webroot') . '/upload/images/';
 
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
 
		if ($_FILES['file']['type'] == 'image/png' 
		|| $_FILES['file']['type'] == 'image/jpg' 
		|| $_FILES['file']['type'] == 'image/gif' 
		|| $_FILES['file']['type'] == 'image/jpeg'
		|| $_FILES['file']['type'] == 'image/pjpeg')
		{
			copy($_FILES['file']['tmp_name'], $dir . time() . $_FILES['file']['name']);
 
			echo Yii::app()->baseUrl . '/upload/images/' . time() . $_FILES['file']['name'];
		}
	}

    public function actionPageView()
    {
        if(!Yii::app()->request->isAjaxRequest || false === ($path = Yii::app()->request->getPost('path')))
            Yii::app()->end();
        $count = 0;
        if($model = PageView::model()->updateByPath($path))
            $count = $model->views + 1;
        echo CJSON::encode(array(
            'count' => (int)$count,
        ));
    }

	public function actionShowComments()
	{
		$this->widget('CommentWidget', array(
			'model' => $_POST['model'],
			'object_id' => $_POST['object_id'],
			'onlyList' => TRUE,
		));
	}

	public function actionSendComment()
	{
		$comment = new Comment;
		$comment->attributes = $_POST['Comment'];
		$comment->author_id = Yii::app()->user->id;
		if ($comment->save())
		{
			$response = array(
				'status' => 'ok',
			);
		}
		else
		{
			$response = array(
				'status' => 'error',
			);
		}
		echo CJSON::encode($response);
	}

	public function actionUserViaCommunity()
	{
		$user = User::model()->with('communities')->findByPk(Yii::app()->user->id);
		$communities = $user->communities;
		$_communities = array();
		foreach ($communities as $c)
		{
			if ($c->id != 2) $_communities[] = $c->id;
		}
		$user->communities = $_communities;
		$user->saveRelated('communities');
	}

	public function actionAcceptReport()
	{
		if ($_POST['Report'])
		{
			$report = new Report;
			$report->setAttributes($_POST['Report'], FALSE);
			$report->informer_id = Yii::app()->user->id;
			$report->type = 'Другое';
			$report->save();
		}
	}

	public function actionShowReport()
	{
		$accepted_models = array(
			'CommunityComment',
			'CommunityContent',
            'RecipeBookRecipe',
            'MessageDialog',
            'MessageLog'
		);
	
		$source_data = $_POST['source_data'];
		if (in_array($source_data['model'], $accepted_models))
		{
			$this->widget('ReportWidget', array('source_data' => $source_data));
		}
	}

	public function actionView($path)
	{
		$this->renderPartial($path);
	}
	
	public function actionVideo()
	{
		$link = $_POST['url'];
		
		$video = new Video($link);
		
		$host = parse_url($link, PHP_URL_HOST);
		$favicon_url = 'http://www.google.com/s2/favicons?domain=' . $host;
		$favicon = strtr($host, array('.' => '_')) . '.png';
		$favicon_path = Yii::getPathOfAlias('webroot') . '/upload/favicons/' .  $favicon;
		file_put_contents($favicon_path, file_get_contents($favicon_url));
		
		$this->renderPartial('video_preview', array(
			'video' => $video,
			'favicon' => $favicon,
		));
	}
	
	public function actionSource()
	{
		switch ($_POST['source_type'])
		{
			case 'book':
				$this->renderPartial('source_type/preview/book', array(
					'author' => $_POST['book_author'],
					'name' => $_POST['book_name'],
				));
				break;
			case 'internet':
				$link = $_POST['internet_link'];
				$html = file_get_contents($link);
				$title = preg_match('/<title>(.+)<\/title>/', $html, $matches) ? $matches[1] : $link;
				$title = mb_convert_encoding($title, 'UTF-8', 'cp1251');
				
				$host = parse_url($link, PHP_URL_HOST);
				$favicon_url = 'http://www.google.com/s2/favicons?domain=' . $host;
				$favicon = strtr($host, array('.' => '_')) . '.png';
				$favicon_path = Yii::getPathOfAlias('webroot') . '/upload/favicons/' .  $favicon;
				file_put_contents($favicon_path, file_get_contents($favicon_url));
				
				$this->renderPartial('source_type/preview/internet', array(
					'title' => $title,
					'favicon' => $favicon,
				));
				break;
		}
	}

	public function actionSave()
	{
		print_r($_POST);
		$user = User::model()->findByPk(Yii::app()->user->getId());
		$user->setAttributes($_POST['User']);
		$user->save(TRUE, array('first_name', 'last_name', 'nick', 'birthday', 'settlement_id'));
	}
	
	public function actionSaveChild()
	{
		//sleep(2);
		$baby = Baby::model()->findByPk($_POST['Baby']['id']);
		$baby->setAttributes($_POST['Baby']);
		$baby->save(TRUE, array('name', 'birthday'));
		echo json_encode($baby->getAttributes());
	}
	
	public function actionSettlements()
	{
		$data = GeoRusSettlement::model()->findAll('region_id=:region_id', array(':region_id'=>(int) $_POST['region_id']));

		$data = CHtml::listData($data,'id','name');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), TRUE);
		}
	}
	
	public function actionRubrics()
	{
		$rubrics = CommunityRubric::model()->findAll('community_id=:community_id', array(':community_id'=>(int) $_POST['community_id']));
		
		echo CHtml::tag('span', array('val' => '0', 'class' => 'cuselActive'), 'Выберите рубрику');
		foreach ($rubrics as $r)
		{
			echo CHtml::tag('span', array('val' => $r->id), CHtml::encode($r->name));
		}
	}

    public function actionVote()
    {
        if (Yii::app()->request->isAjaxRequest && ! Yii::app()->user->isGuest)
        {
            $object_id = $_POST['object_id'];
            $vote = $_POST['vote'];
            $model = $_POST['model']::model()->findByPk($object_id);

            if ($model)
            {
                $depends = Yii::app()->user->id;
                if (isset($_POST['depends'])){
                    $depends = array('user_id'=>Yii::app()->user->id);
                    foreach($_POST['depends'] as $key=>$value)
                        $depends[$key] = $value;
                }

                $model->vote($depends, $vote);
                $model->refresh();

                $response = array('success' => true);
                foreach ($model->vote_attributes as $key => $value) {
                    $response[$value] = $model->$value;
                    $response[$value.'_percent'] = $model->getPercent($key);
                }
                if (isset($model->vote_attributes[0]) && isset($model->vote_attributes[1])){
                    $response['rating'] = $model->{$model->vote_attributes[1]} - $model->{$model->vote_attributes[0]};
                }
            }
            else
                $response = array('success' => false);

            echo CJSON::encode($response);
        }
    }
}