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
        array(2) {
        [0]=> array(12) {
            ["Table"]=> string(14) "bag_offer_vote" ["Non_unique"]=> string(1) "0" ["Key_name"]=> string(8) "offer_id" ["Seq_in_index"]=> string(1) "1" ["Column_name"]=> string(7) "user_id" ["Collation"]=> string(1) "A" ["Cardinality"]=> string(1) "0" ["Sub_part"]=> NULL ["Packed"]=> NULL ["Null"]=> string(0) "" ["Index_type"]=> string(5) "BTREE" ["Comment"]=> string(0) "" } [1]=> array(12) {
            ["Table"]=> string(14) "bag_offer_vote" ["Non_unique"]=> string(1) "1" ["Key_name"]=> string(23) "bag_user_vote_object_fk" ["Seq_in_index"]=> string(1) "1" ["Column_name"]=> string(9) "object_id" ["Collation"]=> string(1) "A" ["Cardinality"]=> string(1) "0" ["Sub_part"]=> NULL ["Packed"]=> NULL ["Null"]=> string(0) "" ["Index_type"]=> string(5) "BTREE" ["Comment"]=> string(0) "" } }
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