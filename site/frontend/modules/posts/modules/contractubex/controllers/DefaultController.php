<?php
namespace site\frontend\modules\posts\modules\contractubex\controllers;
use site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper;

/**
 * @author Никита
 * @date 03/12/15
 */

class DefaultController extends \LiteController
{
    public $litePackage = 'contractubex';

    public function actionIndex()
    {
        $forum = ContractubexHelper::getForum();
        $this->render('index', compact('forum'));
    }
}