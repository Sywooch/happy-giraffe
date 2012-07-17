<?php
    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.count > a',
        'entity' => get_class($model),
        'entity_id' => $model->id,
        'singlePhoto' => true,
    ));
?>

<div id="photo-inline" itemscope itemtype="http://schema.org/ImageObject">

    <div class="meta">

        <div class="clearfix">

            <div class="count">
                <?=$currentIndex?> фото из <?=count($collection['photos'])?> <a href="javascript:void(0)" class="btn btn-green-smedium" data-id="<?=$photo->id?>"><span><span>Смотреть весь альбом</span></span></a>
            </div>

            <div class="album-title">
                <?=$collection['title']?>
            </div>

        </div>

    </div>

    <div class="title"><h1 itemprop="name"><?=$photo->w_title?></h1></div>

    <div class="img">

        <div class="user clearfix">

            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $photo->author,
                'size' => 'small',
                'sendButton' => false,
                'location' => false
            )); ?>

        </div>

        <?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), '', array('itemprop' => 'contentURL'))?>

        <meta itemprop="width" content="250 px">
        <meta itemprop="height" content="250 px">

    </div>

    <div class="photo-comment" itemprop="description"><?=$photo->w_description?></div>

</div>