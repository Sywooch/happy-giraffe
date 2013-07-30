<?php

class DefaultController extends HController
{
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
        $json = compact('initialIndex', 'initialPhotos', 'initialPhotoId', 'count');

        $this->renderPartial('window', compact('json'));
	}

    public function actionPreloadNext($collectionClass, $collectionOptions, $photoId)
    {
        $collection = new $collectionClass($collectionOptions);
        $photos = $collection->getNextPhotos($photoId, 10);

        $response = compact('photos');
        echo CJSON::encode($response);
    }

    public function actionPreloadPrev($collectionClass, $collectionOptions, $photoId)
    {
        $collection = new $collectionClass($collectionOptions);
        $photos = $collection->getPrevPhotos($photoId, 10);

        $response = compact('photos');
        echo CJSON::encode($response);
    }
}