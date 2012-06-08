<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class ActivityController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Самое свежее на Веселом Жирафе';
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
        $friends = User::findFriends(12);

        $this->render('friends', compact('friends'));
    }

    public function actionFriendsNext($page)
    {
        $friends = User::findFriends(12, ($page - 1) * 12);

        $this->renderPartial('_friends', compact('friends'));
    }
}
