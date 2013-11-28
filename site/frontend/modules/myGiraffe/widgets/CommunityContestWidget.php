<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/14/13
 * Time: 5:25 PM
 * To change this template use File | Settings | File Templates.
 */

class CommunityContestWidget extends CWidget
{
    public function run()
    {
        $contest = CommunityContest::model()->find(array(
            'scopes' => array('active'),
            'order' => 'id DESC',
        ));

        if ($contest !== null) {
            $contestShown = UserAttributes::get(Yii::app()->user->id, 'contestShown' . $contest->id, false);

            if ($contestShown === false) {
                $this->render('CommunityContestWidget', compact('contest'));
                UserAttributes::set(Yii::app()->user->id, 'contestShown' . $contest->id, true);
            }
        }
    }
}