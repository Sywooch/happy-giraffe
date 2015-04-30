<?php

/**
 * @var AlbumPhoto $model
 * @var bool $edit редактирование
 */
if (!isset($edit))
    $edit = false;

$add = empty($model->title) ? '' : ' title="' . $model->title . '" alt="' . $model->title . '"';

if (!$edit)
    echo '<!-- widget: { entity : "AlbumPhoto", entity_id : "' . $model->id . '" } -->';

$newPhoto = \site\frontend\modules\photo\components\MigrateManager::movePhoto($model);
if($newPhoto) {
    if (isset($parentModel) && in_array(get_class($parentModel), array('Comment', 'MessagingMessage')))
        //echo '<a class="comments-gray_cont-img-w" onclick="PhotoCollectionViewWidget.open(\'AttachPhotoCollection\', { entityName : \'' . get_class($parentModel) . '\', entityId : \'' . $parentModel->id . '\' }, \'' . $model->id . '\')"><img src="' . $model->getPreviewUrl(485, 110, Image::HEIGHT) . '"></a>';
        echo '<a class="comments-gray_cont-img-w" onclick="PhotoCollectionViewWidget.open(\'AttachPhotoCollection\', { entityName : \'' . get_class($parentModel) . '\', entityId : \'' . $parentModel->id . '\' }, \'' . $model->id . '\')">' . $model->getPreviewHtml(395, 400, Image::AUTO) . '</a>';
    else {
        if ($model->width >= 580) {
            if (!$edit)
                echo '<div class="b-article_in-img b-article_in-img__l">';
            echo '<img src="' . Yii::app()->thumbs->getThumb($newPhoto, 'postImage', true) . '" class="content-img"' . $add . '>';
            if (!$edit)
                echo '</div>';
        } else {
            if (!$edit)
                echo '<div class="b-article_in-img">';
            echo '<img src="' . Yii::app()->thumbs->getThumb($newPhoto, 'postImage', true) . '" class="content-img"' . $add . '>';
            if (!$edit)
                echo '</div>';
        }
    }
    if (!$edit)
        echo '<!-- /widget -->';
}