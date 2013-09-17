<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/6/13
 * Time: 1:10 PM
 * To change this template use File | Settings | File Templates.
 */
class SearchController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
           // 'ajaxOnly - index',
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
        $countries = array_map(function($country) {
            return array(
                'id' => $country->id,
                'name' => $country->name,
            );
        }, GeoCountry::model()->findAll(array('order' => 't.name ASC')));
        $friendsCount = Friend::model()->getCountByUserId(Yii::app()->user->id);
        $json = compact('countries');

        $this->pageTitle = 'Найти друзей';
        $this->render('index', compact('json', 'friendsCount'));
    }

    public function actionGet()
    {
        $dp = FriendsSearchManager::getDataProvider(Yii::app()->user->id, $_GET);
        $dp->data;
        die;
        $users = array_map(function($user) {
            return array(
                'id' => null,
                'user' => FriendsManager::userToJson($user),
            );
        }, $dp->data);
        $currentPage = $dp->pagination->currentPage + 1;
        $pageCount = $dp->pagination->pageCount;
        $data = compact('users', 'currentPage', 'pageCount');
        echo CJSON::encode($data);
    }
}
