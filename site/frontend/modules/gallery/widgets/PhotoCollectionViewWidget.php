<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/9/13
 * Time: 1:45 PM
 * To change this template use File | Settings | File Templates.
 */

class PhotoCollectionViewWidget extends CWidget
{
    public function run()
    {
        $this->registerScripts();
    }

    protected function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile('/javascripts/ko_gallery.js')
            ->registerScriptFile($baseUrl . '/PhotoCollectionViewWidget.js')
        ;
    }
}