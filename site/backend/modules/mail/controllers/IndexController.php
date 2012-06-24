<?php
/**
 * User: Eugene Podosenov
 * Date: 15.06.12
 */
class IndexController extends BController
{
    public $layout = '//layouts/club';
    public $defaultAction='index';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionCreate()
    {
        $this->render('create');
    }
}
