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
    public function actionIndex()
    {
        $countries = array_map(function($country) {
            return array(
                'id' => $country->id,
                'name' => $country->name,
            );
        }, GeoCountry::model()->findAll(array('order' => 't.name ASC')));
        $data = compact('countries');

        $this->render('index', compact('data'));
    }

    public function actionGet()
    {
        $dp = FriendsSearchManager::getDataProvider(Yii::app()->user->id, $_GET);
        $users = array_map(array($this, 'populateFriend'), $dp->data);
        $currentPage = $dp->pagination->currentPage + 1;
        $pageCount = $dp->pagination->pageCount;
        $data = compact('users', 'currentPage', 'pageCount');
        echo CJSON::encode($data);
    }

    protected function populateFriend($friend)
    {
        return $this->renderPartial('_friend', $friend, true);
    }
}
