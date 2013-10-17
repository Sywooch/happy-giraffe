<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 4:59 PM
 * To change this template use File | Settings | File Templates.
 */

class CommunityMoreWidget extends CWidget
{
    public $content;

    public function run()
    {
        $this->render('CommunityMoreWidget');
    }
}