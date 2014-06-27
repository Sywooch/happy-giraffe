<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 19/06/14
 * Time: 14:50
 */



namespace site\frontend\modules\photo\controllers;

\Yii::setPathOfAlias('League',\Yii::getPathOfAlias('application.vendor.League'));
\Yii::setPathOfAlias('Guzzle',\Yii::getPathOfAlias('application.vendor.Guzzle'));
\Yii::setPathOfAlias('Aws',\Yii::getPathOfAlias('application.vendor.Aws'));
\Yii::setPathOfAlias('Symfony',\Yii::getPathOfAlias('application.vendor.Symfony'));

use site\frontend\modules\photo\models\PhotoAlbum;

use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\AwsS3 as Adapter;
use League\Flysystem\Adapter\Local as Adapter2;

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
        $client = S3Client::factory(array(
            'key'    => 'AKIAIRCLO4AYJCJRTV4Q',
            'secret' => '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',
        ));

        \Yii::beginProfile('block1');
        $filesystem = new Filesystem(new Adapter($client, 'test-happygiraffe'));
        $file = $filesystem->read('1344242897872.jpg');
        \Yii::endProfile('block1');

        \Yii::beginProfile('block2');
        $filesystem2 = new Filesystem(new Adapter2(\Yii::getPathOfAlias('webroot')));
        $filesystem2->read('1344242897872.jpg');
        \Yii::endProfile('block2');
    }


}

