<?php

class DefaultController extends HController
{
    public $layout = '//layouts/common_new';

    public function actionIndex()
    {
        $this->render('index');
    }

	public function actionWindow($collectionClass, $initialPhotoId)
	{
        $collectionOptions = Yii::app()->request->getQuery('collectionOptions');
        $collection = new $collectionClass($collectionOptions);
        $initialIndex = $collection->getIndexById($initialPhotoId);
        $initialPhotos = $collection->getPhotosInRange($initialPhotoId, 5, 5);
        $count = $collection->count;
        $url = $collection->url;
        $json = compact('initialIndex', 'initialPhotos', 'initialPhotoId', 'count', 'collectionClass', 'collectionOptions', 'url');

        $this->renderPartial('window', compact('json'));
	}

    public function actionPreloadNext($collectionClass, $photoId, $number)
    {
        $collectionOptions = Yii::app()->request->getQuery('collectionOptions', array());
        $collection = new $collectionClass($collectionOptions);
        $photos = $collection->getNextPhotos($photoId, $number);

        $response = compact('photos');
        echo CJSON::encode($response);
    }

    public function actionPreloadPrev($collectionClass, $photoId, $number)
    {
        $collectionOptions = Yii::app()->request->getQuery('collectionOptions', array());
        $collection = new $collectionClass($collectionOptions);
        $photos = $collection->getPrevPhotos($photoId, $number);

        $response = compact('photos');
        echo CJSON::encode($response);
    }
}