<?php

namespace site\frontend\modules\posts\controllers;

/**
 * Description of TempController
 *
 * @author Кирилл
 */
class TempController extends \LiteController
{

    public $litePackage = 'posts';
    public function actionTemp()
    {
        var_dump(\site\frontend\modules\som\modules\photopost\models\Photopost::model()->find()->save());
    }

}
