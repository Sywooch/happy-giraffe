<?php

class CommunityController extends Controller
{

	public $layout = '//layouts/main';

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index', 'list', 'view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions' => array('add', 'edit'),
				'users' => array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$communities = Community::model()->findAll();
		$this->render('index', array(
			'communities' => $communities,
		));
	}

	public function actionList($community_id, $content_type_slug = 'article', $rubric_id = NULL)
	{
		
		if ($content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug)))
		{
			$community_id = (int) $community_id;
			if (!is_null($rubric_id)) $rubric_id = (int) $rubric_id;
			if ($community = Community::model()->with('rubrics')->findByPk($community_id))
			{
				$content_types = CommunityContentType::model()->findAll();
				$current_rubric = CommunityRubric::model()->findByPk($rubric_id);
				
				$criteria = CommunityContent::model()->community($community_id)->type($content_type->id)->rubric($rubric_id)->getDbCriteria();
				$count = CommunityContent::model()->count($criteria);
				$pages = new CPagination($count);
				$pages->pageSize = 10;
				$pages->applyLimit($criteria);		
				$contents = CommunityContent::model()->findAll($criteria);
				
				$this->render('list', array(
					'community' => $community,
					'contents' => $contents,
					'content_type' => $content_type,
					'content_types' => $content_types,
					'current_rubric' => $current_rubric,
					'rubric_id' => $rubric_id,
					'pages' => $pages,
				));
			}
			else
			{
				throw new CHttpException(404, 'Такого сообщества не существует.');
			}
		}
		else
		{
			throw new CHttpException(404, 'Такого раздела не существует.');
		}
	}
	
	public function actionView($content_id)
	{
		$content_id = (int) $content_id;
		if ($content = CommunityContent::model()->view()->findByPk($content_id))
		{
			$content->views++;
			$content->save();
			$comment_model = new CommunityComment;
			$content_types = CommunityContentType::model()->findAll();
			
			$related = CommunityContent::model()->with('type', 'article', 'video')->findAll(array(
				'condition' => 'rubric_id=:rubric_id AND type_id=:type_id AND t.id!=:current_id',
				'params' => array(':rubric_id' => $content->rubric_id, ':type_id' => $content->type->id, ':current_id' => $content->id),
				'limit' => 3,
				'order' => 'rand()',
			));
			
			if (isset($_POST['CommunityComment']))
			{
				$comment_model->attributes = $_POST['CommunityComment'];
				$comment_model->content_id = $content_id;
				$comment_model->author_id = Yii::app()->user->id;
				$comment_model->save();
				//костыль
				$content = CommunityContent::model()->view()->findByPk($content_id);
			}
			
			$this->render('content', array(
				'c' => $content,
				'related' => $related,
				'comment_model' => $comment_model,
				'content_types' => $content_types,
			));
		}
		else
		{
			throw new CHttpException(404, 'Такой записи не существует.');
		}
	}
	
	public function actionEdit($content_id)
	{
		$content_id = (int) $content_id;
		$content_model = CommunityContent::model()->with(array('type', 'article', 'video', 'rubric.community'))->findByPk($content_id);
		if ($content_model === null)
		{
			throw new CHttpException(404, 'Такой записи не существует.');
		}
		$communities = Community::model()->findAll();
		$slave_model = $content_model->{$content_model->type->slug};
		$slave_model_name = get_class($slave_model);
		
		if (isset($_POST['CommunityContent'], $_POST[$slave_model_name]))
		{
			$content_model->attributes = $_POST['CommunityContent'];
			$slave_model->attributes = $_POST[$slave_model_name];
			$slave_model->attributes = $_POST;
			$valid = $content_model->validate();
			$valid = $slave_model->validate() && $valid;
		
			if ($valid)
			{
				$content_model->save();
				$slave_model->save();
				$this->redirect(array('community/view', 'content_id' => $content_model->id));
			}
		}
		
		$this->render('edit', array(
			'communities' => $communities,
			'content_model' => $content_model,
			'slave_model' => $slave_model,
			'community' => $content_model->rubric->community,
			'content_type' => $content_model->type,
		));
	}

	public function actionAdd($content_type_slug = 'article', $community_id, $rubric_id = null)
	{	
		$content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug));
		if (! $content_type)
		{
			throw new CHttpException(404, 'Такого раздела не существует.');
		}
		$community = Community::model()->with('rubrics')->findByPk($community_id);
		if (! $community)
		{
			throw new CHttpException(404, 'Такого сообщества не существует.');
		}
		$content_types = CommunityContentType::model()->findAll();
		$content_model = new CommunityContent;
		$content_model->rubric_id = $rubric_id;
		$slave_model_name = 'Community' . ucfirst($content_type->slug);
		$slave_model = new $slave_model_name;
	
		if (isset($_POST['CommunityContent']))
		{
			$content_model->attributes = $_POST['CommunityContent'];
			$slave_model->attributes = $_POST[$slave_model_name];
			$slave_model->setAttributes($_POST);
			$content_model->author_id = Yii::app()->user->id;
			if ($content_model->save())
			{
				$slave_model->content_id = $content_model->id;
				if ($slave_model->save())
				{
					if (is_null($community_id))
					{
						$this->redirect('community/index');
					}
					else
					{
						$this->redirect(array('community/view', 'content_id' => $content_model->id));
					}
				}
				else
				{
					$content_model->delete();
					print_r($slave_model->getErrors());
				}
			}
			else
			{
				print_r($content_model->getErrors());
			}
		}
	
		$this->render('add', array(
			'content_model' => $content_model,
			'slave_model' => $slave_model,
			'community' => $community,
			'content_types' => $content_types,
			'content_type' => $content_type,
			'community_id' => $community_id,
			'rubric_id' => $rubric_id,
		));
	}
}