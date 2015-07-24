<?php

namespace site\frontend\modules\som\modules\status\commands;

/**
 * Команда переност эмоции из старой бд, с сохранением идентификаторов,
 * и переносит статусы пользователей.
 *
 * @author Кирилл
 */
class MigrateCommand extends \CConsoleCommand
{

    public function actionIndex()
    {
        $st = new \CActiveDataProvider('site\frontend\modules\som\modules\status\models\Status');
        $i = new \CDataProviderIterator($st, 100);

        foreach ($i as $status) {
            $status->save();
        }
    }

}
