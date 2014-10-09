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
use Imagine\Imagick\Image;
use Imagine\Imagick\Imagine;
use League\Flysystem\Filesystem;
use site\frontend\modules\photo\components\observers\PhotoCollectionGreedyObserver;
use site\frontend\modules\photo\components\observers\PhotoCollectionIdsObserver;
use site\frontend\modules\photo\components\observers\PhotoCollectionNeatObserver;
use site\frontend\modules\photo\components\PhotoCollectionObserver;
use site\frontend\modules\photo\components\PhotoController;
use site\frontend\modules\photo\models\ImageStringData;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class TestController extends PhotoController
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

    public function actionCrop()
    {
        \Yii::app()->gearman->doBackground('lol', 'ok');
//        $photo = Photo::model()->findByPk(114);
//        echo $photo->getOriginalUrl();


//        $photo = Photo::model()->findByPk(113);
//
//        $cropData = array(
//            'x' => 100,
//            'y' => 100,
//            'w' => 100,
//            'h' => 100,
//        );
//
//        echo \Yii::app()->crops->getCrop($photo, 'avatarBig', $cropData, true)->getUrl();

//        $x = 0;
//        $y = 0;
//        $w = 580;
//        $h = 580;
//
//        $photo = Photo::model()->findByPk(106);
//
//        $thumb = \Yii::app()->thumbs->getCrop($photo, 'avatarBig', $x, $y, $w, $h);
//        $thumb->show();
    }

    public function actionObserver()
    {
        \Yii::beginProfile('slice');
        for ($i = 0; $i < 100; $i++) {
            $collection = PhotoCollection::model()->findByPk(9);
            $obs = new PhotoCollectionIdsObserver($collection);
            $photos = $obs->getSlice(5, mt_rand(0, $obs->getCount() - 1));
        }
        foreach ($photos as $v) {
            echo "{$v->id}<br>";
        }
        \Yii::endProfile('slice');


        \Yii::beginProfile('single');
        for ($i = 0; $i < 100; $i++) {
            $collection = PhotoCollection::model()->findByPk(9);
            $obs = new PhotoCollectionIdsObserver($collection);
            $photo = $obs->getSingle(mt_rand(0, $obs->getCount() - 1));
        }
        foreach ($photo->getAttributes() as $k => $v) {
            echo "$k: $v<br>";
        }
        \Yii::endProfile('single');
    }

    public function actionScript()
    {
        $criteria = new \CDbCriteria(array(
            'scopes' => array(
                'collection' => 36,
            ),
        ));

        echo count(PhotoAttach::model()->findAll($criteria));
    }

    public function actionSleep()
    {
        sleep(5);
        echo "alert('спящая реклама');";
    }

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
        phpinfo();




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

    public function actionAlbums()
    {
        $albums = PhotoAlbum::model()->user(\Yii::app()->user->id)->findAll();
        $json = \HJSON::encode($albums, array(
            'site\frontend\modules\photo\models\PhotoAlbum' => array(
                'id',
                'title',
                'description',
                'photoCollection' => array(
                    'site\frontend\modules\photo\models\PhotoCollection' => array(
                        'id',
                        '(int)attachesCount',
                        'attaches',
                        'cover',
                    ),
                ),
            ),
        ));
        $this->render('albums', compact('json'));
    }
}

