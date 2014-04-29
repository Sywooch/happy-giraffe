<?php

class DefaultController extends HController
{
    public $layout = '//layouts/common_new';

    public function actionIndex()
    {
        $this->render('index');
    }

	public function actionWindow($collectionClass, $initialPhotoId = null)
	{
        $screenWidth = Yii::app()->request->getQuery('screenWidth');
        $dimension = $this->getUserDimension($screenWidth);
        Yii::app()->user->setState('dimension', $dimension);
        $windowOptions = Yii::app()->request->getQuery('windowOptions');
        $collectionOptions = Yii::app()->request->getQuery('collectionOptions');
        $collection = new $collectionClass($collectionOptions);
        if ($initialPhotoId === null)
            $initialPhotoId = $collection->photoIds[0];
        $initialIndex = $collection->getIndexById($initialPhotoId);
        $initialPhotos = $collection->getPhotosInRange($initialPhotoId, 5, 5);
        $count = $collection->count;
        $properties = $collection->properties;
        $user = Yii::app()->user->isGuest ? null : array(
            'id' => Yii::app()->user->id,
            'firstName' => Yii::app()->user->model->first_name,
            'lastName' => Yii::app()->user->model->last_name,
            'gender' => Yii::app()->user->model->gender,
            'ava' => Yii::app()->user->model->getAvatarUrl(Avatar::SIZE_MICRO),
            'url' => Yii::app()->user->model->url,
        );
        $json = compact('initialIndex', 'initialPhotos', 'initialPhotoId', 'count', 'collectionClass', 'collectionOptions', 'user', 'windowOptions', 'properties');

        $this->renderPartial('window', compact('json', 'collection'), false, true);
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

    protected function getUserDimension($screenWidth)
    {
        foreach (AlbumPhoto::$photoViewDimensions as $dimensionId => $dimension)
            if (($dimension['minScreenWidth'] === null || $screenWidth >= $dimension['minScreenWidth']) && ($dimension['maxScreenWidth'] === null || $screenWidth <= $dimension['maxScreenWidth']))
                return $dimensionId;
    }

    public function actionSinglePhoto($entity, $photo_id)
    {
        switch ($entity) {
            case 'CommunityContentGallery':
                $contentId = Yii::app()->request->getQuery('content_id');
                $model = CommunityContent::model()->findByPk($contentId);
                $relatedModel = CommunityContentGalleryItem::model()->find(array(
                    'with' => 'gallery',
                    'condition' => 'content_id = :content_id AND photo_id = :photo_id',
                    'params' => array(
                        ':content_id' => $contentId,
                        ':photo_id' => $photo_id,
                    ),
                ));
                $collectionClass = 'PhotoPostPhotoCollection';
                $collectionOptions = array('contentId' => $contentId);
                break;
            case 'Contest':
                $contestId = Yii::app()->request->getQuery('contest_id');
                $model = Contest::model()->findByPk($contestId);
                $collectionClass = 'ContestPhotoCollection';
                $collectionOptions = array('contestId' => $contestId);
                break;
            default:
                throw new CHttpException(404);
        }

        if ($model === null)
            throw new CHttpException(404);

        $collection = new $collectionClass($collectionOptions);
        if (array_search($photo_id, $collection->photoIds) === false)
            throw new CHttpException(404);

        $photo = AlbumPhoto::model()->findByPk($photo_id);
        $photoCollectionElement = $collection->getPhoto($photo_id, true);
        $nextPhotoId = $collection->getNextPhotosIds($photo_id, 1);
        $nextPhotoUrl = preg_replace('#(\d+)\/$#', $nextPhotoId[0] . '/', Yii::app()->request->url);
        $prevPhotoId = $collection->getPrevPhotosIds($photo_id, 1);
        $prevPhotoUrl = preg_replace('#(\d+)\/$#', $prevPhotoId[0] . '/', Yii::app()->request->url);

        $this->layout = '//layouts/main';
        $this->pageTitle = $photoCollectionElement['title'] . ' - ' . $collection->properties['title'];
        $this->render('singlePhoto', compact('collection', 'photo', 'photoCollectionElement', 'currentIndex', 'nextPhotoUrl', 'prevPhotoUrl', 'entity', 'relatedModel'));
    }

    public function actionContestData($contestId, $photoId)
    {
        $contest = Contest::model()->findByPk($contestId);
        $photo = AlbumPhoto::model()->findByPk($photoId);
        $attach = $photo->getAttachByEntity('ContestWork');
        $this->renderPartial('contestData', compact('contest', 'attach'), false, true);
    }
}