<?php

class Test2Controller extends Controller
{
	public function actionCount()
	{
		$c = Community::model()->findByPk(1);
		echo $c->getCount(1);
	}

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
		//var_dump(Yii::app()->user->settlement_id);
        var_dump(Yii::app()->db->createCommand('SHOW INDEX FROM bag_offer_vote')->queryAll());
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

    public function actionParseStats(){
        $url = 'http://www.liveinternet.ru/stat/blog.mosmedclinic.ru/queries.html?id=139;id=3224346;id=3138283;id=3224088;id=3225442;date=2011-12-31;period=month;page=';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_COOKIE, 'session=0708ZM0mw8qJ; suid=0HL2kG3LzWGy; per_page=100; adv-uid=2d663d.2664c3.bcd35c'); // allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);

        echo $result;
    }

}