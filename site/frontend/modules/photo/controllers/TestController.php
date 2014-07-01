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

    public function actionPresets()
    {
        $photo = Photo::model()->find();
        /** @var \site\frontend\modules\photo\components\thumbs\ThumbsManager $thumbsManager */
        $thumbsManager = \Yii::app()->getModule('photo')->thumbs;
        //$thumbsManager->saveThumb($photo, 'uploadMin');

        echo \CHtml::link($thumbsManager->getThumb($photo, 'uploadMin'), $thumbsManager->getThumb($photo, 'uploadMin'));
    }

    public function actionFlysystem()
    {
        //header('Content-Type: image/jpeg');

        //$a = \Yii::app()->getModule('photo')->fs->read('1344242897872.jpg');

        $imagine = new Imagine();
        $image = $imagine->open(\Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '14-01-06.jpg');

        \Yii::beginProfile('ok');
        for ($i = 0; $i < 10; $i++) {
            $image->resize(new Box(mt_rand(100, 1000), mt_rand(100, 1000)));
            //$image->show('png');
        }
        \Yii::endProfile('ok');
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

