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

                        <div class="album-title"><b>Альбом</b> <?=CHtml::link($album->title, $album->url)?>
                            <?php if(!Yii::app()->user->isGuest && $this->user->id == Yii::app()->user->id): ?>
                                <?php
                                Yii::import('application.controllers.AlbumsController');
                                AlbumsController::loadUploadScritps();
                                $link = Yii::app()->createUrl('/albums/addPhoto')
                                ?>
                                <a class="btn btn-orange-smallest a-right fancy" href="<?php echo $link; ?>"><span><span>Загрузить фото</span></span></a>
                                <?php endif; ?>
                        </div>
                        <?php if ($album->description): ?>
                            <div class="album-description"><?=$album->description?></div>
                        <?php endif; ?>

                        <div class="album-photos">

                            <ul>
                                <?php foreach ($album->getRelated('photos', false, array('order' => 'RAND()', 'limit' => 5)) as $photo): ?>
                                    <li><?=CHtml::link(CHtml::image($photo->getPreviewUrl(210, null, Image::WIDTH)), $album->url)?></li>
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

        <?php if (Yii::app()->user->id == $this->user->id): ?>
            <div class="upload-photo-btn">
                <?php
                    AlbumsController::loadUploadScritps();
                    echo CHtml::link(CHtml::image('/images/btn_upload_photo.png'), array('addPhoto'), array('class' => 'fancy btn btn-green'));
                ?>
            </div>
        <?php endif; ?>

    </div>


</div>