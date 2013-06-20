<?php
/**
 * @var AlbumPhoto $model
 */
?>

<?=CHtml::image($model->getPreviewUrl(700, 700, Image::WIDTH), $model->title, array('title' => $model->title))?>