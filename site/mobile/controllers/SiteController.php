<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/4/13
 * Time: 4:16 PM
 * To change this template use File | Settings | File Templates.
 */
class SiteController extends CController
{
    public function actionIndex()
    {
        $this->render('index');
    }
}
