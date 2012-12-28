<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/27/12
 * Time: 3:01 PM
 * To change this template use File | Settings | File Templates.
 */
class DefaultController extends HController
{
    public $broadcast = true;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + ajax,moreItems'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('moreItems'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex()
    {
        $dp = EventManager::getIndex(10);

        $this->pageTitle = 'Что нового на сайте - Веселый Жираф';

        $this->render('index', compact('dp'));
    }

    public function actionClubs($show)
    {
        $dp = EventManager::getClubs(30, $show);

        $this->pageTitle = 'Что нового в клубах - Веселый Жираф';

        $this->render('clubs', compact('dp', 'show'));
    }

    public function actionBlogs($show)
    {
        $dp = EventManager::getBlogs(30, $show);

        $this->pageTitle = 'Что нового в блогах - Веселый Жираф';

        $this->render('blogs', compact('dp', 'show'));
    }

    public function actionAjax()
    {
        $type = Yii::app()->request->getPost('type');

        $this->widget('WhatsNewWidget', array('type' => $type, 'checkVisible' => false));
    }

    public function actionMoreItems()
    {
        $offset = Yii::app()->request->getPost('offset');
        $page = round($offset / 4) + 1;
        $dp = EventManager::getDataProvider(EventManager::WHATS_NEW_ALL, 4, $page);

        foreach ($dp->data as $block)
            echo $block->code;
    }
}
