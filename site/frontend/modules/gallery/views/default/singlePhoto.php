<?php
/**
 * @var PhotoCollection $collection
 * @var AlbumPhoto $photo
 * @var $photoCollectionElement
 * @var string $nextPhotoUrl
 * @var string $prevPhotoUrl
 */
Yii::app()->clientScript->registerPackage('gallery');
?>

<div class="content-cols clearfix">
    <div class="col-1">
        <div class="b-user-info margin-t15 clearfix">
            <?php $this->widget('Avatar', array('user' => $photo->author)) ?>
            <div class="b-user-info_hold">
                <a class="b-user-info_name" href="<?=$photo->author->getUrl() ?>"><?=$photo->author->getFullName() ?></a>
                <div class="b-user-info_date"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $photo->created)?></div>
            </div>
        </div>
        <?php if ($photoCollectionElement['title']): ?>
            <div class="title-blue"><?=$photoCollectionElement['title']?></div>
        <?php endif; ?>
        <?php if ($photoCollectionElement['description']): ?>
            <div class=""><?=$photoCollectionElement['description']?></div>
        <?php endif; ?>
    </div>
    <div class="col-23-middle">
        <div class="photo-view clearfix">
            <div class="photo-view_top clearfix">

                <div class="meta-gray">
                    <a class="meta-gray_comment" href="">
                        <span class="ico-comment ico-comment__gray"></span>
                        <span class="meta-gray_tx"><?=$photo->commentsCount?></span>
                    </a>
                    <div class="meta-gray_view">
                        <span class="ico-view ico-view__gray"></span>
                        <span class="meta-gray_tx"><?=$this->getViews()?></span>
                    </div>
                </div>
                <div class="photo-view_tx"><?=$collection->getIndexById($photo->id) + 1?> из <?=$collection->count?></div>
                <div class="photo-view_tx"><?=$collection->properties['label']?> <a href="<?=$collection->properties['url']?>"><?=$collection->properties['title']?></a></div>

            </div>
            <div class="photo-view_c">
                <div class="photo-view_img">
                    <!-- Отлавливать клик или на ссылку или на изображение (тогда ссылка не нужна) -->
                    <a href="javascript:void(0)" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($photo->id)?>)">
                        <?=CHtml::image($photo->getPreviewUrl(680, null, Image::WIDTH))?>
                    </a>
                </div>
                <a href="<?=$prevPhotoUrl?>" class="photo-view_arrow photo-view_arrow__l"></a>
                <a href="<?=$nextPhotoUrl?>" class="photo-view_arrow photo-view_arrow__r"></a>
                <div class="like-control clearfix">
                    <?php $this->widget('application.modules.blog.widgets.LikeWidget', array('model' => $photo)); ?>
                    <?php $this->widget('FavouriteWidget', array('model' => $photo)); ?>
                </div>
            </div>
            <div class="photo-view_row clearfix">
                <a href="javascript:void(0)" class="i-more float-r" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($photo->id)?>)">Смотреть все</a>
                <a href="javascript:void(0)" class="photo-view_fullscreen" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($photo->id)?>)">
                    <span class="photo-view_fullscreen-in">Полный размер</span>
                </a>
            </div>

            <?php if ($entity == 'Contest'): ?>
                <?php $work = $photo->getAttachByEntity('ContestWork')->model; ?>
                <div class="photo-view_contest clearfix">
                    <div class="photo-window_contest-logo">
                        <a href="<?=$work->contest->url?>">
                            <img src="/images/contest/photo-window_contest-logo_<?=$work->contest_id?>.png" alt="">
                        </a>
                    </div>


                    <div class="photo-window-contest-meter">
                        <div class="photo-window-contest-meter_count">
                            <div class="photo-window-contest-meter_num"><?=$work->rate?></div>
                            <div class="photo-window-contest-meter_ball"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $work->rate)?></div>
                        </div>
                        <?php if ($work->contest->status == Contest::STATUS_ACTIVE): ?>
                        <div class="photo-window-contest-meter_vote">
                            <div class="photo-window-contest-meter_vote-tx">Голосовать!</div>
                            <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
                                'title' => 'Вам понравилось фото?',
                                'notice' => '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>',
                                'model' => $work,
                                'type' => 'simple',
                                'options' => array(
                                    'title' => CHtml::encode($photo->w_title),
                                    'image' => $photo->getPreviewUrl(180, 180),
                                    'description' => $photo->w_description,
                                ),
                            ));  ?>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>

                <?php if (Yii::app()->user->id == $work->user_id): ?>
                    <?php if (Yii::app()->user->id == $work->user_id): ?>
                        <div class="sharelink-friends">
                            <div class="clearfix">
                                <div class="sharelink-friends_t">Cсылка на конкурсную работу</div>
                                <input type="text" onclick="$(this).select();" value="<?=$work->getUrl(false, true)?>" class="sharelink-friends_itx">

                            </div>
                            <div class="sharelink-friends_desc">Хочешь победить в конкурсе? Разошли эту ссылку друзьям и знакомым, сделай подписью в скайпе, аське и статусом в социальных сетях. Чем больше человек проголосует за твою работу, тем выше шансы на победу!</div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <?php if (! Yii::app()->user->checkAccess('tester')): ?>
                    <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
                        'title' => 'Вам понравилось фото?',
                        'notice' => '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>',
                        'model' => $photo,
                        'type' => 'simple',
                        'options' => array(
                            'title' => CHtml::encode($photo->w_title),
                            'image' => $photo->getPreviewUrl(180, 180),
                            'description' => $photo->w_description,
                        ),
                    ));  ?>
                <?php endif; ?>
                <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $relatedModel)); ?>
            <?php endif; ?>

        </div>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $photo, 'full' => true)); ?>

        <?php $this->widget('application.modules.blog.widgets.PostUsersWidget', array('post' => $photo)); ?>
    </div>
</div>