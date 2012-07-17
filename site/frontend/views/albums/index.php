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

            <?php foreach ($dataProvider->data as $album): ?>
                <div id="gallery" class="nopadding">

                    <div class="gallery-album">

                        <div class="album-title"><?=CHtml::link($album->title, $album->url)?></div>
                        <?php if ($album->description): ?>
                            <div class="album-description"><?=$album->description?></div>
                        <?php endif; ?>

                        <div class="album-photos">

                            <ul>
                                <?php foreach ($album->getRelated('photos', false, array('order' => 'RAND()', 'limit' => 2)) as $photo): ?>
                                    <li><?=CHtml::image($photo->getPreviewUrl(210, null, Image::WIDTH))?></li>
                                <?php endforeach; ?>
                                <?php if (($count = count($album->photos)) > 2): ?>
                                    <li class="more"><?=CHtml::link('<i class="icon"></i>еще ' . ($count - 2) . ' фото', $album->url)?></li>
                                <?php endif; ?>
                            </ul>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

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