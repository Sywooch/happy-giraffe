<?php
/**
 * Временный контроллер для костыльной правки страницы фото
 *
 * @author Никита
 * @date 21/04/15
 */

class TmpController extends LiteController
{
    public $litePackage = 'photo';

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

        $this->layout = '//layouts/lite/main';
        $this->pageTitle = $photoCollectionElement['title'] . ' - ' . $collection->properties['title'];
        $this->render('singlePhoto', compact('collection', 'photo', 'photoCollectionElement', 'currentIndex', 'nextPhotoUrl', 'prevPhotoUrl', 'entity', 'relatedModel'));
    }
}