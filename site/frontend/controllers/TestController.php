<?php

class TestController extends Controller
{

	public function actionFix()
	{
		$contents = CommunityContent::model()->findAll(array('select' => 'id, author_id', 'order' => 'id DESC'));
		foreach ($contents as $c)
		{
			echo 'UPDATE `club_community_content` SET `author_id`=' . $c->author_id . ' WHERE `id`=' . $c->id . ';' . "\n";
		}
	}

	public function actionIndex()
	{
		phpinfo();
		die;
		$this->widget('ext.blocks.BlockWidget', array(
			'params' => array(
				'url' => CController::createAbsoluteUrl('test/test'),
				'data' => array(
					'label' => 'test',
				),
			),
		));
	}
	
	public function actionTest()
	{
		var_dump(Yii::app()->user->settlement_id);
	}

	public function actionVideo()
	{
		$video = new Video('http://www.youtube.com/watch?v=6hQfzL18NDY');
		echo $video->title;
	}
	
	public function actionImport()
	{
		Yii::import('ext.excelReader.Spreadsheet_Excel_Reader');
		$data = new Spreadsheet_Excel_Reader('giraffe.xls');
		$i = 0;
		while ($community_name = $data->val(1, ++$i))
		{
			$community = new Community;
			$community->name = $community_name;
			$community->save(false);
			$j = 2;
			while ($rubric_name = $data->val(++$j, $i))
			{
				$rubric = new CommunityRubric;
				$rubric->name = $rubric_name;
				$rubric->community_id = $community->id;
				$rubric->save(false);
			}
		}
	}

}