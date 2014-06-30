<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 19/06/14
 * Time: 14:50
 */



namespace site\frontend\modules\photo\controllers;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Imagick\Imagine;

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

    public function actionFlysystem()
    {
        header('Content-Type: image/jpeg');

        $a = \Yii::app()->getModule('photo')->fs->read('1344242897872.jpg');

        $imagine = new Imagine();
        $image = $imagine->load($a);
        $image->crop(new Point(0, 0), new Box(500, 500));

        echo $image->get('png');
    }


}

