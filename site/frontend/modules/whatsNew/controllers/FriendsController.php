<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/5/12
 * Time: 3:26 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendsController extends HController
{
    public $broadcast = true;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex()
    {
        if (Yii::app()->request->isAjaxRequest)
            $this->layout = 'empty';
//        $status = CommunityContent::model()->resetScope()->findByAttributes(array('type_id' => 5));
//        FriendEventManager::add(FriendEvent::TYPE_STATUS_UPDATED, array('model' => $status));
        $dp = FriendEventManager::getDataProvider(Yii::app()->user->model);

        $this->pageTitle = 'Что нового у моих друзей - Веселый Жираф';

        $this->render('index', compact('dp'));
    }
}
