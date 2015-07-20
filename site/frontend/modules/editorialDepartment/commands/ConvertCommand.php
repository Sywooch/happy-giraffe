<?php
/**
 * @author Никита
 * @date 20/07/15
 */
namespace site\frontend\modules\editorialDepartment\commands;

use site\frontend\modules\editorialDepartment\models\Content;

class ConvertCommand extends \CConsoleCommand
{
    public function actionTest()
    {
        $content = Content::model()->findByAttributes(array(
            'entity' => "site\\frontend\\modules\\posts\\models\\api\\Content",
            'entityId' => 687454,
        ));
        $content->save();
    }
}