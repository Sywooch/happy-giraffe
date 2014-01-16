<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 16/01/14
 * Time: 17:35
 * To change this template use File | Settings | File Templates.
 */

class AntispamCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        while (true) {
            $models = AntispamCheck::model()->findAll('status = :status AND created < ' . new CDbExpression('DATE_SUB(NOW(), INTERVAL 15 MINUTE)'), array(':status' => AntispamCheck::STATUS_PENDING));
            foreach ($models as $m)
                $m->changeStatus(AntispamCheck::STATUS_UNDEFINED);
            sleep(60);
        }
    }
}