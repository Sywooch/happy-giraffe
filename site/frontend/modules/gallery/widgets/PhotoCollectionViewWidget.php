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
    public $collection;
    public $width;
    public $thresholdCoefficient = 0.775;
    public $minPhotos = 3;

    public function run()
    {
        $this->registerScripts();

        $grid = array();
        $buffer = array();
        foreach ($this->collection->getAllPhotos() as $photo) {
            $buffer[] = $photo->photo;
            $height = floor($this->getHeight($buffer));

            if (count($buffer) >= $this->minPhotos && $height <= $this->getThreshold($buffer)) {
                $grid[] = array(
                    'height' => $height,
                    'photos' => $buffer,
                );
                $buffer = array();
            }
        }

        $this->render('index', compact('collection', 'grid'));
    }

    public function getHeight($photos)
    {
        return ($this->width - count($photos) * 4) / array_reduce($photos, function($v, $w) {
            $v += $w->originalWidth / $w->originalHeight;
            return $v;
        }, 0);
    }

    public function getThreshold($photos)
    {
        $balance = array_reduce($photos, function($v, $w) {
            $v += (($w->originalWidth / $w->originalHeight) > 1) ? 1 : -1;
            return $v;
        }, 0);
        $orientCoefficient = $balance <= 0 ? 2 : 1;
        return 580 / count($photos) * $this->thresholdCoefficient * $orientCoefficient;
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

//class PhotoCollectionViewWidget extends CWidget
//{
//    public function run()
//    {
//        $this->registerScripts();
//    }
//
//    protected function registerScripts()
//    {
//        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
//        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
//        Yii::app()->clientScript
//            ->registerScriptFile('/javascripts/ko_gallery.js')
//            ->registerScriptFile($baseUrl . '/PhotoCollectionViewWidget.js')
//        ;
//    }
//}