<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/10/13
 * Time: 3:14 PM
 * To change this template use File | Settings | File Templates.
 */
class MController extends CController
{
    public $communities = array();

    public function init()
    {
        $this->communities = MobileCommunity::model()->findAll();
        parent::init();
    }

    public function getViews()
    {
        $path = '/' . Yii::app()->request->pathInfo . '/';

        return PageView::model()->incViewsByPath($path);
    }
}
