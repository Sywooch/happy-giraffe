<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 10:52 AM
 * To change this template use File | Settings | File Templates.
 */

Yii::import('site.seo.models.mongo.ProxyMongo');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.common.models.mongo.SiteEmail');
Yii::import('site.seo.components.ProxyParserThread');
Yii::import('application.components.OsinkaParser');
require_once(Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php');

class EmailParsingCommand extends CConsoleCommand
{
    public function actionOsinka($threadId)
    {
        $parser = new OsinkaParser($threadId);
        $parser->start();
    }
}