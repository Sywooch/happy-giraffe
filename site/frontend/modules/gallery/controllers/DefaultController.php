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
        $windowOptions = Yii::app()->request->getQuery('windowOptions');
        $collectionOptions = Yii::app()->request->getQuery('collectionOptions');
        $collection = new $collectionClass($collectionOptions);
        $initialIndex = $collection->getIndexById($initialPhotoId);
        $initialPhotos = $collection->getPhotosInRange($initialPhotoId, 5, 5);
        $count = $collection->count;
        $url = $collection->url;
        $userId = Yii::app()->user->id;
        $json = compact('initialIndex', 'initialPhotos', 'initialPhotoId', 'count', 'collectionClass', 'collectionOptions', 'url', 'userId', 'windowOptions');

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

    public function actionComments()
    {
        $photo = AlbumPhoto::model()->findByPk(Yii::app()->request->getPost('id'));
        echo $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $photo, 'gallery' => true), true);
    }

    public function actionUpdateTitle()
    {
        $id = Yii::app()->request->getPost('id');
        $title = Yii::app()->request->getPost('title');

        $success = AlbumPhoto::model()->updateByPk($id, array('title' => $title)) > 0;
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionUpdateDescription()
    {
        $id = Yii::app()->request->getPost('id');
        $contentId = Yii::app()->request->getPost('contentId');
        $description = Yii::app()->request->getPost('description');

        $item = CommunityContentGalleryItem::model()->with('gallery')->findByAttributes(array('photo_id' => $id), 'content_id = :contentId', array(':contentId' => $contentId));
        $item->description = $description;
        $success = $item->update(array('description'));
        $response = compact('success');
        echo CJSON::encode($response);
    }
}