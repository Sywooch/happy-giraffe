<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/27/12
 * Time: 3:01 PM
 * To change this template use File | Settings | File Templates.
 */
class WhatsNewController extends HController
{
    public function init()
    {
        Yii::import('application.models.whatsNew.*');

        parent::init();
    }

    public function actionIndex()
    {
        $dp = EventManager::getLive(100);

        $this->render('index', compact('dp'));
    }

    public function actionClubs()
    {

    }

    public function actionBlogs()
    {

    }

    public function actionFriends()
    {

    }
}
