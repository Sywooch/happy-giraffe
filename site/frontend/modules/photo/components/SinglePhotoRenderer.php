<?php
/**
 * @author Никита
 * @date 06/11/14
 */

namespace site\frontend\modules\photo\components;


use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class SinglePhotoRenderer
{
    public static function render(PhotoCollection $collection, Photo $photo)
    {
        $attach = PhotoAttach::model()->collection($collection->id)->photo($photo->id)->with('photo')->find();
        if ($attach === null) {
            throw new \CHttpException(404);
        }

        \Yii::app()->controller->breadcrumbs += array(
            $attach->title,
        );
        \Yii::app()->controller->pageTitle = $attach->title;

        $attachNext = $collection->observer->getNext($attach->id);
        $attachPrev = $collection->observer->getPrev($attach->id);
        \Yii::app()->controller->render('photo.views.single', compact('collection', 'attach', 'attachPrev', 'attachNext'));
    }
} 