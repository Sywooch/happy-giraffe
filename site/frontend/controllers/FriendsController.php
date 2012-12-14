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
    const BY_ONLINE = 0;
    const BY_REGION = 1;
    const BY_INTERESTS = 2;
    const BY_STATUS = 3;

    public function actionFind($type)
    {
        $this->render('find');
    }
}
