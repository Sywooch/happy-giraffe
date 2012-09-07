<?php
    $cs = Yii::app()->clientScript;

    $cs

    ;
?>

<div id="user">

    <div class="main">
        <div class="main-in">

            <div class="content-title-new">
                Фотоальбомы
            </div>

            <div id="gallery" class="nopadding">

                <?php foreach ($dataProvider->data as $model): ?>

                    <?php if ($model->photoCount > 0): ?>

                        <?php
                            $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
                                'selector' => '.gallery-album:data(id=' . $model->id . ') .img > a, .gallery-album:data(id=' . $model->id . ') .slideshow',
                                'entity' => 'Album',
                                'entity_id' => $model->id,
                                'entity_url' => $model->url,
                            ));

                            $_firstPhoto = $model->getRelated('photos', false, array('limit' => 1, 'order' => 'id ASC'));
                            $firstPhoto = $_firstPhoto[0];
                        ?>

                        <div class="gallery-album clearfix" data-id="<?=$model->id?>">

                            <div class="album-title"><?=CHtml::link($model->title, $model->url)?><?php if (Yii::app()->user->id == $this->user->id): ?> <?= CHtml::link('', array('albums/updateAlbum', 'id' => $model->id), array('class' => 'settings tooltip fancy', 'title' => 'Настройки альбома')) ?><?php endif; ?></div>
                            <?php if ($model->description): ?>
                                <div class="album-description"><?=$model->description?></div>
                            <?php endif; ?>

                            <div class="album-actions">

                                <span class="count"><i class="icon"></i> <?=$model->photoCount?> фото</span>
                                <a href="javascript:void(0)" class="slideshow" data-id="<?=$firstPhoto->id?>">Слайд-шоу</a>
                                <?=CHtml::link('Открыть альбом', $model->url)?>

                            </div>

                            <div class="album-photos">

                                <div class="gallery-photos-new cols-3 clearfix">
                                    <ul>

                                        <?php foreach ($model->getRelated('photos', false, array('limit' => 3, 'order' => new CDbExpression('RAND()'))) as $photo): ?>
                                            <?=$this->renderPartial('_photo', array('data' => $photo))?>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>


                            </div>

                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>

                <?php if ($model->author_id == Yii::app()->user->id) CHtml::link('', array('addPhoto'), array('class' => 'fancy btn-album-create'))?>

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