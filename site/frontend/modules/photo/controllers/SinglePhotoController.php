<?php
/**
 * @author Никита
 * @date 07/11/14
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\modules\family\models\Family;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class SinglePhotoController extends \LiteController
{
    public $litePackage = 'photo';

    public function actionPhotoPost($user_id, $content_id, $photo_id)
    {
        $oldPhoto = \AlbumPhoto::model()->with('newPhoto')->findByPk($photo_id);
        if ($oldPhoto === null || $oldPhoto->newPhoto === null) {
            throw new \CHttpException(404);
        }

        $post = \CommunityContent::model()->with('author')->findByPk($content_id);
        if ($post === null || $post->author_id != $user_id) {
            throw new \CHttpException(404);
        }

        $this->breadcrumbs = array(
            'Блог' => array('/blog/default/index', 'user_id' => $post->author->id),
        );

        $collection = $post->getPhotoCollection();
        $this->renderSinglePhoto($collection, $oldPhoto->newPhoto->id);
    }

    public function actionAlbum($userId, $albumId, $photoId)
    {
        $album = PhotoAlbum::model()->with('author')->findByPk($albumId);
        if ($album === null || $album->author->id != $userId) {
            throw new \CHttpException(404);
        }

        $this->breadcrumbs = array(
            'Фото' => array('/photo/default/index', 'userId' => $album->author->id),
        );
        $this->metaNoindex = true;

        $collection = $album->getPhotoCollection();
        $this->renderSinglePhoto($collection, $photoId);
    }

    public function actionFamily($userId, $photoId)
    {
        $family = Family::model()->hasMember($userId)->find();
        if ($family === null) {
            throw new \CHttpException(404);
        }

        $this->metaCanonical = $family->getUrl();

        $collection = $family->getPhotoCollection('all');
        $this->renderSinglePhoto($collection, $photoId);
    }

    protected function renderSinglePhoto(PhotoCollection $collection, $photoId)
    {
        $attach = PhotoAttach::model()->collection($collection->id)->photo($photoId)->with('photo', 'photo.author')->find();
        if ($attach === null) {
            throw new \CHttpException(404);
        }

        $attachNext = $collection->observer->getNext($attach->id);
        $attachPrev = $collection->observer->getPrev($attach->id);
        $this->render('index', compact('collection', 'attach', 'attachPrev', 'attachNext'));
    }
} 