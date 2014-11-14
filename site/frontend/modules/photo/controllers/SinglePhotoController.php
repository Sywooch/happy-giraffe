<?php
/**
 * @author Никита
 * @date 07/11/14
 */

namespace site\frontend\modules\photo\controllers;


use site\frontend\modules\photo\models\Photo;
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

        $collection = $post->getPhotoCollection();
        $this->renderSinglePhoto($collection, $oldPhoto->newPhoto);
    }

    protected function renderSinglePhoto(PhotoCollection $collection, Photo $photo)
    {
        $attach = PhotoAttach::model()->collection($collection->id)->photo($photo->id)->with('photo', 'photo.author')->find();
        if ($attach === null) {
            throw new \CHttpException(404);
        }

        $attachNext = $collection->observer->getNext($attach->id);
        $attachPrev = $collection->observer->getPrev($attach->id);
        \Yii::app()->controller->render('index', compact('collection', 'attach', 'attachPrev', 'attachNext'));
    }
} 