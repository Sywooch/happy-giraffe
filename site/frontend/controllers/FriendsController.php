<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/14/12
 * Time: 12:22 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendsController extends HController
{
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

    public function actionFind($type)
    {
        $dp = FindFriendsManager::getDataProvider($type);

        $this->render('find', compact('dp', 'type'));
    }
}
