<?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerScriptFile('/javascripts/viewAlbum.js')
    ;
?>

<div id="user">

    <div class="main">
        <div class="main-in">

            <div class="content-title-new">
                Фотоальбомы
            </div>


            <div id="gallery" class="nopadding">
                <?php foreach ($dataProvider->data as $album): ?>
                    <div class="gallery-album" data-count="<?=count($album->photos)?>">

                        <div class="album-title"><?=CHtml::link($album->title, $album->url)?></div>
                        <?php if ($album->description): ?>
                            <div class="album-description"><?=$album->description?></div>
                        <?php endif; ?>

                        <div class="album-photos">

                            <ul>
                                <?php foreach ($album->getRelated('photos', false, array('order' => 'RAND()', 'limit' => 5)) as $photo): ?>
                                    <li><?=CHtml::image($photo->getPreviewUrl(210, null, Image::WIDTH))?></li>
                                <?php endforeach; ?>
                                <li class="more"><?=CHtml::link('<i class="icon"></i>еще <span class="count"></span> фото', $album->url)?></li>
                            </ul>

                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

    <div class="side-left gallery-sidebar">

        <div class="clearfix user-info-big">
            <?php
                $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $this->user,
                    'location' => false,
                    'friendButton' => true,
                    'nav' => true,
                    'status' => true,
                ));
            ?>
        </div>

    </div>


</div>