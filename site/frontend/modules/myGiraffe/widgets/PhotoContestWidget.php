<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 18/11/13
 * Time: 10:41
 * To change this template use File | Settings | File Templates.
 */

class PhotoContestWidget extends CWidget
{
    public function run()
    {
        $contest = Contest::model()->find(array(
            'scopes' => array('active'),
            'order' => 'id DESC',
        ));

        if ($contest !== null) {
            $contestShown = false;// UserAttributes::get(Yii::app()->user->id, 'photoContestShow' . $contest->id, false);

            if ($contestShown === false) {
                $criteria = new CDbCriteria();
                $criteria->compare('contest_id', $contest->id);
                $criteria->order = new CDbExpression('RAND()');
                $criteria->limit = 3;
                $participants = ContestWork::model()->findAll($criteria);
                $this->render('PhotoContestWidget', compact('contest', 'participants'));
                UserAttributes::set(Yii::app()->user->id, 'photoContestShow' . $contest->id, true);
            }
        }
    }
}