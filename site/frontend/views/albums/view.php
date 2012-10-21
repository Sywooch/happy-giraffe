<?php
Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

$this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
    'selector' => '.img > a',
    'entity' => 'Album',
    'entity_id' => $model->id,
));
?>

<div id="user">

    <div class="main">
        <div class="main-in">

            <div class="content-title-new">
                Альбом «<?=$model->title?>»<?php if (Yii::app()->user->id == $this->user->id): ?> <?= CHtml::link('', array('albums/updateAlbum', 'id' => $model->id), array('class' => 'settings tooltip fancy', 'title' => 'Настройки альбома')) ?><?php endif; ?>
                <?php if ($model->description): ?>
                    <span><?=$model->description?></span>
                <?php endif; ?>
            </div>

            <div id="gallery" class="nopadding">

                <div class="gallery-photos-new cols-3 clearfix">

                    <?php
                    $this->widget('MyListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_photo',
                        'summaryText' => 'показано: {start} - {end} из {count}',
                        'pager' => array(
                            'class' => 'AlbumLinkPager',
                        ),
                        'id' => 'photosList',
                        'itemsTagName' => 'ul',
                        //'template' => '{items}<div class="pagination pagination-center clearfix">{pager}</div>',
                        'template' => '{items}',
                        'viewData' => array(
                            'currentPage' => $dataProvider->pagination->currentPage,
                        ),
                        'emptyText'=>'В этом альбоме у вас нет фотографий'
                    ));

                    $this->widget('PhotosAjaxMasonry', array(
                            'dataProvider' => $dataProvider,

                            'gallerySelector' => '.img > a',
                            'galleryEntity' => 'Album',
                            'galleryEntity_id' => $model->id,

                            'masonryContainerSelector' => '#photosList ul.items',
                            'masonryItemSelector' => 'li',
                            'masonryColumnWidth' => 240
                        )
                    );
                    ?>

                </div>


            </div>

        </div>
    </div>

    <div class="side-left gallery-sidebar">

        <div class="clearfix">
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

        <?php if (Yii::app()->user->id == $this->user->id): ?>
            <div class="upload-photo-btn">
                <?php
                    AlbumsController::loadUploadScritps();
                    echo CHtml::link(CHtml::image('/images/btn_upload_photo.png'), array('addPhoto', 'a' => $model->id), array('class' => 'fancy btn btn-green'));
                ?>
            </div>
        <?php endif; ?>

        <div class="club-topics-list-new">

            <div class="block-title">Мои альбомы</div>

            <?php
            $items = array();
            $items[] = array(
                'label' => 'Все альбомы',
                'url' => array('albums/user', 'id' => $this->user->id),
                'template' => '<span>{menu}</span>',
            );

            foreach ($model->author->albums('albums:noSystem') as $album) {
                if (count($album->photos) > 0 || $this->user->id == Yii::app()->user->id)
                $items[] = array(
                    'label' => $album->title,
                    'url' => $album->url,
                    'template' => '<span>{menu}</span><div class="count">' . $album->photoCount . '</div>',
                    'active' => $album->id == $model->id,
                );
            }

            $this->widget('zii.widgets.CMenu', array(
                'items' => $items,
            ));
            ?>

        </div>

    </div>

</div>

<?php
if (Yii::app()->user->id == $this->user->id) {
    $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
    $remove_tmpl->registerTemplates();
    $this->endWidget();
}
?>