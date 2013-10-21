<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/21/13
 * Time: 1:41 PM
 * To change this template use File | Settings | File Templates.
 */

class CommunityPopularWidget extends CWidget
{
    public $club;

    public function run()
    {
        echo '<!-- popular club ' . $this->club->id . ' -->';

        $popular = ClubPopular::model()->findByAttributes(array(
            'date' => date('Y-m-d'),
            'clubId' => (int) $this->club->id,
        ));

        if ($popular !== null) {
            echo '<!-- popular found -->';

            $criteria = new CDbCriteria();
            $criteria->addInCondition('t.id', $popular->contents);
            $contents = CommunityContent::model()->findAll($criteria);

            if ($contents) {
                echo '<!-- popular render -->';
                $this->render('CommunityPopularWidget', compact('contents'));
            }
        }
    }
}