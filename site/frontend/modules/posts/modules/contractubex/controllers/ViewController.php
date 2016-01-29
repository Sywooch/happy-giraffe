<?php
/**
 * @author Никита
 * @date 03/12/15
 */

namespace site\frontend\modules\posts\modules\contractubex\controllers;


use site\frontend\modules\posts\controllers\PostController;

class ViewController extends PostController
{
    public $layout = '/layouts/contractubex';
    public $litePackage = 'contractubex';
}