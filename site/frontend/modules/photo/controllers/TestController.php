<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 19/06/14
 * Time: 14:50
 */



namespace site\frontend\modules\photo\controllers;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Imagine\Imagick\Imagine;
use League\Flysystem\Filesystem;
use site\frontend\modules\photo\models\Photo;

class TestController extends \HController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public $layout = '//layouts/new/main';

    public function actionPresets()
    {
        echo \CJSON::encode(\Yii::app()->thumbs->presets);
    }

    public function actionTest()
    {
        $album = PhotoAlbum::model()->with('photoCollection.attachesCount')->find();
        echo $album->photoCollection->attachesCount;
    }

    public function actionUploadSingle()
    {
        $this->render('uploadSingle');
    }

    public function actionUploadMultiple()
    {
        $this->render('uploadMultiple');
    }

//    public function actionPresets()
//    {
//        $photo = Photo::model()->find();
//        /** @var \site\frontend\modules\photo\components\thumbs\ThumbsManager $thumbsManager */
//        $thumbsManager = \Yii::app()->thumbs;
//        $thumb = $thumbsManager->getThumb($photo, 'uploadMin');
//
//        echo \CHtml::image($thumb->getUrl(), '', array('width' => $thumb->getWidth(), 'height' => $thumb->getHeight()));
//    }

    public function actionFlysystem()
    {
        $imagine = new Imagine();
        $image = $imagine->load(file_get_contents('http://upload.wikimedia.org/wikipedia/commons/2/2c/Rotating_earth_%28large%29.gif'));

        $image->layers()->coalesce();
        foreach ($image->layers() as $frame) {
            $frame->resize(new Box(100, 100));
        }

        $image->save(\Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '1.gif', array('animated' => true));


//        \Yii::app()->gearman->client()->doBackground('createThumbs', '123');
//
//        die;
//        //header('Content-Type: image/jpeg');
//        header('Content-Type: text/html; charset=utf-8');
//        /** @var \Gaufrette\Filesystem $fs */
//        $fs = \Yii::app()->fs;

//        print_r($fs->listCon)


//        \Yii::beginProfile('test1');
//        $fs->read('originals/fb/02/d7daf1e1645d502f0cf42446f916.jpg');
//        \Yii::endProfile('test1');
//
//        \Yii::beginProfile('file-get-contents');
//        echo file_get_contents(\Yii::getPathOfAlias('site.common.data.temp') . '/originals/fb/02/d7daf1e1645d502f0cf42446f916.jpg');
//        \Yii::endProfile('file-get-contents');
    }

    protected function test($width, $height, &$image)
    {
        $size = $image->getSize();
        $ratio = $size->getWidth() / $size->getHeight();
        $image->resize(new Box($ratio * $height, $height));
        if ($ratio >= $width / $height) {
            $image->crop(new Point(($ratio * $height - $height) / 2, 0), new Box($width, $height));
        }
    }
}

