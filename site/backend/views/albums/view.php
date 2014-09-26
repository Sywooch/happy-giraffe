<?php
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
                Альбом «<?=$model->title?>
                »<?php if (Yii::app()->user->id == $this->user->id): ?> <?= CHtml::link('', '#albumSettings', array('class' => 'settings tooltip fancy', 'title' => 'Настройки альбома')) ?><?php endif; ?>
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

<div style="display:none">
    <div id="albumSettings" class="popup">

        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>

        <div class="popup-title">Настройки фотоальбома</div>

        <!--<div class="default-nav">
            <ul>
                <li class="active"><a href="">Название альбома</a></li>
                <li class="disabled"><a>Настройки 2</a></li>
                <li class="disabled"><a>Настройки 3</a></li>
            </ul>
        </div>-->

        <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => array('/ajax/setValues/'),
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnType' => true,
        ),
        'htmlOptions' => array(
            'onsubmit' => 'ajaxSetValues(this, function(response) {if (response) {$.fancybox.close(); window.location.reload();}}); return false;',
        ),
    )); ?>
        <?=CHtml::hiddenField('entity', get_class($model))?>
        <?=CHtml::hiddenField('entity_id', $model->id)?>

        <div class="settings-form">

            <div class="row">
                <div class="row-title">Название альбома <span>(не более 30 знаков)</span></div>
                <div class="row-elements"<?php if (!$model->title): ?> style="display: none;"<?php endif; ?>>
                    <span class="item-title"><?=$model->title?></span>
                    <a href="javascript:void(0)" onclick="Album.updateField(this)" class="edit tooltip" title="Редактировать название альбома"></a>
                </div>
                <div class="row-elements"<?php if ($model->title): ?> style="display: none;"<?php endif; ?>>
                    <?=$form->textField($model, 'title', array('placeholder' => 'Введите название альбома'))?>
                    <button onclick="Album.updateFieldSubmit(this, '.item-title'); return false;" class="btn btn-green-small"><span><span>Ok</span></span></button>
                </div>
                <?=$form->error($model, 'title')?>

            </div>
            <div class="row">
                <div class="row-title">Комментарий к альбому</div>
                <div class="row-elements"<?php if (!$model->description): ?> style="display: none;"<?php endif; ?>>
                    <p><span><?=$model->description?></span><a href="javascript:void(0)" onclick="Album.updateField(this)" class="edit tooltip" title="Редактировать описание альбома"></a></p>
                </div>
                <div class="row-elements"<?php if ($model->description): ?> style="display: none;"<?php endif; ?>>
                    <?=$form->textField($model, 'description')?>
                    <button onclick="Album.updateFieldSubmit(this, 'p > span'); return false;" class="btn btn-green-small"><span><span>Ok</span></span></button>
                </div>
                <?=$form->error($model, 'description')?>

            </div>

        </div>

        <div class="bottom">
            <button class="btn btn-green-medium"><span><span>Сохранить настройки</span></span></button>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>

<?php
if (Yii::app()->user->id == $this->user->id) {
    $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
    $remove_tmpl->registerTemplates();
    $this->endWidget();
}
?>