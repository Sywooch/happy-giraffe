<?php

/**
 * @var AlbumPhoto $model
 * @var bool $edit редактирование
 */
if (!isset($edit))
    $edit = false;

$add = empty($model->title) ? '' : ' title="' . htmlspecialchars($model->title) . '" alt="' . htmlspecialchars($model->title) . '"';

if (!$edit)
    echo '<!-- widget: { entity : "AlbumPhoto", entity_id : "' . $model->id . '" } -->';

$newPhoto = \site\frontend\modules\photo\components\MigrateManager::movePhoto($model);
\CommentLogger::model()->addToLog('_widget', 'newPhoto: ' . is_object($newPhoto) ? get_class($newPhoto) : $newPhoto);
if($newPhoto) {
    \CommentLogger::model()->addToLog('_widget', '$newPhoto is true');
    if (isset($parentModel) && in_array(get_class($parentModel), array('Comment', 'MessagingMessage')))
    {
        //echo '<a class="comments-gray_cont-img-w" onclick="PhotoCollectionViewWidget.open(\'AttachPhotoCollection\', { entityName : \'' . get_class($parentModel) . '\', entityId : \'' . $parentModel->id . '\' }, \'' . $model->id . '\')"><img src="' . $model->getPreviewUrl(485, 110, Image::HEIGHT) . '"></a>';
        \CommentLogger::model()->addToLog('_widget', "if (isset(parentModel) && in_array(get_class(parentModel), array('Comment', 'MessagingMessage')))");
        echo '<a class="comments-gray_cont-img-w" onclick="PhotoCollectionViewWidget.open(\'AttachPhotoCollection\', { entityName : \'' . get_class($parentModel) . '\', entityId : \'' . $parentModel->id . '\' }, \'' . $model->id . '\')">' . $model->getPreviewHtml(395, 400, Image::AUTO) . '</a>';
    }
    else
    {
        if ($model->width >= 580) {
            \CommentLogger::model()->addToLog('_widget', "model->width >= 580");
            if (!$edit)
                echo '<div class="b-article_in-img b-article_in-img__l">';
            echo '<img src="' . Yii::app()->thumbs->getThumb($newPhoto, 'postImage', true) . '" class="content-img"' . $add . '>';
            if (!$edit)
                echo '</div>';
        } else {
            \CommentLogger::model()->addToLog('_widget', "model->width < 580");
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
else
{
    \CommentLogger::model()->addToLog('_widget', "newPhoto is false");
}