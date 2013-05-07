<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/16/13
 * Time: 7:35 PM
 * To change this template use File | Settings | File Templates.
 */
class HappyBirthdayMiraController extends HController
{
    public $layout = '//layouts/common';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $mira = User::model()->findByPk(22);

        $this->pageTitle = 'С Днём рождения, Мира!';
        $this->render('index', compact('mira'));
    }
}
