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

    }
}
