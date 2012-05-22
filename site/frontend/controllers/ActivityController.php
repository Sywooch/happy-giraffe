<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class ActivityController extends HController
{
    public function actionIndex()
    {
        if (! Yii::app()->user->isGuest) {
            UserAttributes::set(Yii::app()->user->id, 'activityLastVisited', time());
        }
        Yii::import('application.widgets.activity.*');
        $this->render('index');
    }

    public function actionLive()
    {
        $live = new CActiveDataProvider(CommunityContent::model()->full(), array(
            'criteria' => array(
                'order' => 'created DESC',
                'condition' => 'type_id != 4',
            ),
        ));

        $this->render('live', compact('live'));
    }

    public function actionFriends()
    {
        $friends = User::findFriends(60);

        $this->render('friends', compact('friends'));
    }

    public function actionTest()
    {
        var_dump(UserAttributes::get(Yii::app()->user->id, 'activityLastVisited'));
        var_dump(Yii::app()->cache->get('activityLastUpdated'))
    }
}
