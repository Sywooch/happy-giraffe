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
        $dp = EventManager::getIndex(100);

        $this->render('index', compact('dp'));
    }

    public function actionClubs($show)
    {
        $dp = EventManager::getClubs(100, $show);

        $this->render('clubs', compact('dp', 'show'));
    }

    public function actionBlogs($show)
    {
        $dp = EventManager::getBlogs(100, $show);

        $this->render('blogs', compact('dp', 'show'));
    }
}
