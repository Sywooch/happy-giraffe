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
            'entityId' => 695289,
        ));

        var_dump($content);

        //$content->save();
    }

    public function actionTest2()
    {
        $content = Content::model()->findByAttributes(array(
            'entity' => "CommunityContent",
        ));
        echo $content->title;
        $content->save();
    }

    public function actionIndex()
    {
        $c = new \EMongoCriteria();
        $c->addCond('entity', '=', 'CommunityContent');

        $dp = new \EMongoDocumentDataProvider('site\frontend\modules\editorialDepartment\models\Content');
        $iterator = new \CDataProviderIterator($dp, 100);
        foreach ($iterator as $model) {
            $model->save();
        }
    }
}