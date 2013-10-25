<?php
/**
 * @var CommunityContentGalleryWidget $widgetToShow
 */
$item = $widgetToShow->item === null ? $widgetToShow->gallery->items[0] : $widgetToShow->item;
?>

<div class="gallery-widget">
    <div class="gallery-widget_top">
        <div class="gallery-widget_top-tx">еще рекомендуем посмотреть</div>
        <div class="gallery-widget_t"><?=$widgetToShow->gallery->content->title?></div>
    </div>
    <a href="javascript:void(0)" class="gallery-widget_img" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode('PhotoPostPhotoCollection')?>, <?=CJavaScript::encode(array('contentId' => $widgetToShow->gallery->content->id))?>, <?=CJavaScript::encode(null)?>, <?=CJavaScript::encode(array('exitUrl' => $widgetToShow->gallery->content->getUrl()))?>)">
        <?=CHtml::image($item->photo->getPreviewUrl(580, null, Image::WIDTH), $widgetToShow->gallery->content->title)?>
        <span class="ico-play-big"></span>
        <span class="gallery-widget_count"><?=$widgetToShow->gallery->count?> ФОТО</span>
    </a>
    <div class="gallery-widget_bottom clearfix">
        <a href="javascript:void(0)" class="float-r btn-blue-light btn-medium" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode('PhotoPostPhotoCollection')?>, <?=CJavaScript::encode(array('contentId' => $widgetToShow->gallery->content->id))?>, <?=CJavaScript::encode(null)?>, <?=CJavaScript::encode(array('exitUrl' => $widgetToShow->gallery->content->getUrl()))?>)">Смотреть галерею</a>
        <div class="meta-gray">
            <a href="<?=$widgetToShow->gallery->content->getUrl(true)?>" class="meta-gray_comment">
                <span class="ico-comment ico-comment__white"></span>
                <span class="meta-gray_tx"><?=$widgetToShow->gallery->content->getCommentsCount()?></span>
            </a>
            <span class="meta-gray_view">
                <span class="ico-view ico-view__white"></span>
                <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($widgetToShow->gallery->content->getUrl())?></span>
            </span>
        </div>
    </div>
    <?php if (Yii::app()->authManager->checkAccess('communityPhotoWidgets', Yii::app()->user->id)): ?>
        <a href="<?=Yii::app()->createUrl('/community/default/photoWidget', array('contentId' => $widgetToShow->gallery->content->id))?>" class="add-photo-widget active powertip fancy" title="Изменить виджет"></a>
    <?php endif; ?>
</div>