<?php

class DefaultController extends HController
{
    public function actionIndex()
    {
        $this->render('index');
    }

	public function actionWindow($initialPhotoId)
	{
        $collection = new CookDecorPhotoCollection();
        $initialIndex = $collection->getIndexById($initialPhotoId);
        $initialPhotos = $collection->getPhotosInRange($initialPhotoId, 5, 5);
        $count = $collection->count;
        $json = compact('initialIndex', 'initialPhotos', 'initialPhotoId', 'count');

        $this->renderPartial('window', compact('json'));
	}

    public function actionPreloadNext($photoId)
    {
        $collection = new CookDecorPhotoCollection();
        $photos = $collection->getNextPhotos($photoId, 10);

        $response = compact('photos');
        echo CJSON::encode($response);
    }

    public function actionPreloadPrev($photoId)
    {
        $collection = new CookDecorPhotoCollection();
        $photos = $collection->getPrevPhotos($photoId, 10);

        $response = compact('photos');
        echo CJSON::encode($response);
    }
}