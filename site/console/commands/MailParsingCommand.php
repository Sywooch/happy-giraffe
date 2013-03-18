<?php
/**
 * Author: alexk984
 * Date: 28.11.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');

class MailParsingCommand extends CConsoleCommand
{
    public function actionClearDir()
    {
        $dir = Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR;
        $files = glob($dir . '*.{txt}', GLOB_BRACE);
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function actionParse($start = 1)
    {
        Yii::import('site.seo.modules.competitors.components.*');
        $p = new ForumParser;
        $p->start($start);
    }

    public function actionParse2($start = 1)
    {
        Yii::import('site.seo.modules.competitors.components.*');
        $p = new ForumParser2;
        $p->start($start);
    }
}
