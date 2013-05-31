<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 5/31/13
 * Time: 10:36 AM
 * To change this template use File | Settings | File Templates.
 */

class IndexDenCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $model = CommunityContent::model()->full()->findByPk(21);
        $model->searchable->save();
    }
}