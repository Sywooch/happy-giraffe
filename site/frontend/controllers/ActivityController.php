<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class ActivityController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + friendsNext',
        );
    }

    public function actionIndex()
    {
        if (! Yii::app()->user->isGuest)
            UserAttributes::set(Yii::app()->user->id, 'activityLastVisited', time());
        Yii::import('application.widgets.activity.*');

        $this->pageTitle = 'Самое свежее на Веселом Жирафе';
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

        $this->pageTitle = 'Прямой эфир';
        $this->render('live', compact('live'));
    }

    public function actionFriends()
    {
        $friends = User::findFriends(12);

        $this->pageTitle = 'Найти друзей';
        $this->render('friends', compact('friends'));
    }

    public function actionFriendsNext($page)
    {
        $friends = User::findFriends(12, ($page - 1) * 12);

        $this->renderPartial('_friends', compact('friends'));
    }

    public function actionUsers($page = 1)
    {
        $limit = 50;
        $offset = ($page - 1) * $limit;

        $criteria = new EMongoCriteria;
        $criteria->user_id('notIn', array());
        $title = 'Что нового у пользователей';

        $total = UserAction::model()->count($criteria);
        $nextPage = ($total > ($limit + $offset)) ? $page + 1 : false;

        $criteria->limit($limit);
        $criteria->offset($offset);
        $criteria->sort('updated', EMongoCriteria::SORT_DESC);
        $actions = UserAction::model()->findAll($criteria);

        $userIds = array();
        foreach ($actions as $a)
            $userIds[$a->user_id] = $a->user_id;
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $userIds);
        $criteria->index = 'id';
        $users = User::model()->findAll($criteria);

        $this->pageTitle = $title;
        $this->layout = 'user_new';
        $this->render('activity', compact('actions', 'nextPage', 'title', 'type', 'users'));
    }
}
