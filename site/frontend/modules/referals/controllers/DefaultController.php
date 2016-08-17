<?php

namespace site\frontend\modules\referals\controllers;

use site\frontend\modules\referals\components\ReferalsManager;
use site\frontend\modules\referals\models\UserRefLink;

class DefaultController extends \CController
{
    public function actionIndex($ref)
    {
        /**
         * @var UserRefLink $ref
         */
        $ref = UserRefLink::model()
            ->byRef($ref)
            ->find();

        if (!$ref) {
            throw new \HttpException('RefNotFound', 404);
        }

        $redirectUrl = ReferalsManager::handleRef($ref);

        echo $redirectUrl;
    }
}