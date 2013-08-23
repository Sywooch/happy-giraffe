<?php
/**
 * @var AlbumPhoto $model
 * @var bool $edit редактирование
 * @var bool $comments комментарии
 */
if (!isset($edit))
    $edit = false;
if (!isset($comments))
    $comments = false;

$add = empty($model->title) ? '' : ' title="' . $model->title . '" alt="' . $model->title . '"';

if (!$edit) echo '<!-- widget: { entity : "AlbumPhoto", entity_id : "' . $model->id . '" } -->';

if ($comments)
    echo '<a href="javascript:;"><img src="' . $model->getPreviewUrl(165, 1000) . '"></a>';
else {
    if ($model->width >= 580) {
        if (!$edit)
            echo '<div class="b-article_in-img">';
        echo '<img src="' . $model->getPreviewUrl(580, 1000) . '" class="content-img"' . $add . '>';
        if (!$edit)
            echo '</div>';
    } else {
        if (!$edit)
            echo '<div class="clearfix">';
        echo '<img src="' . $model->getPreviewUrl(580, 1000) . '" class="content-img"' . $add . '>';
        if (!$edit)
            echo '</div>';
    }
}
if (!$edit) echo '<!-- /widget -->';