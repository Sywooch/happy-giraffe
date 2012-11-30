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
    public $show;

    public function init()
    {
        Yii::import('application.models.whatsNew.*');
        Yii::import('application.modules.contest.models.*');

        parent::init();
    }

    public function actionIndex()
    {
        $dp = EventManager::getIndex(100);

        $this->render('index', compact('dp'));
    }

    public function actionClubs($show)
    {
        $this->show = $show;

        $dp = EventManager::getClubs(100, $show);

        $this->render('clubs', compact('dp'));
    }

    public function actionBlogs($show)
    {
        $this->show = $show;

        $dp = EventManager::getBlogs(100, $show);

        $this->render('blogs', compact('dp'));
    }
}
