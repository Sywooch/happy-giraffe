<?php
    if (get_class($model) == 'Album')
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.count > a',
        'entity' => get_class($model),
        'entity_id' => $model->id,
        'singlePhoto' => true,
        'entity_url' => (get_class($model) == 'Contest') ? $model->url : null,
    ));
?>

<div id="photo-inline" itemscope itemtype="http://schema.org/ImageObject">


    <div class="content-cols clearfix">

        <div class="col-1">
            <div class="margin-t100">
                <?php $this->renderPartial('//banners/adfox'); ?>
            </div>
        </div>
        <div class="col-23">
            <div class="photo-inline_top">

                <div class="meta">

                    <div class="clearfix">

                        <div class="count">
                            <span class="count-tx">
                                <?php if (get_class($model) == 'CookDecorationCategory'): ?>
                                <?=($model->getIndex($photo->id) + 1)?> фото из <?=$model->getPhotoCollectionCount()?>
                                <?php elseif (get_class($model) != 'Contest'): ?>
                                <?=$currentIndex?><?php if (get_class($model) != 'Album' || $model->id != Album::getAlbumByType(User::HAPPY_GIRAFFE, Album::TYPE_VALENTINE)->id): ?> фото<?php endif; ?> из <?=count($collection['photos'])?>
                                <?php endif; ?>
                            </span>
                            <a href="javascript:void(0)" class="btn-green" data-id="<?=$photo->id?>"><?=(get_class($model) == 'Contest') ? 'Смотреть всех участников' : 'Смотреть весь альбом'?></a>
                        </div>

                        <div class="album-title">
                            <?=$collection['title']?>
                        </div>

                    </div>

                </div>

                <?php if ($photo->w_title): ?>
                <div class="title"><h1 itemprop="name"><?=$photo->w_title?></h1></div>
                <?php endif; ?>

            </div>
            <div class="bordered padding-10">

                <div class="img">

                    <div class="user clearfix">

                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $photo->author,
                            'size' => 'small',
                            'sendButton' => false,
                            'location' => false
                        )); ?>

                        <?php if (get_class($model) == 'Contest' && Yii::app()->user->checkAccess('removeContestWork')): ?>
                            <?php
                                $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                                    'model' => $photo->getAttachByEntity('ContestWork')->model,
                                    'callback' => 'ContestWorkDelete',
                                ));

                                Yii::app()->clientScript->registerScript('removeContestWork', 'function ContestWorkDelete() {
                                    window.location.href = "' . $model->url . '"
                                }',
                                    CClientScript::POS_HEAD);
                            ?>
                        <?php endif; ?>

                    </div>

                    <?php if ($photo->w_title): ?>
                    <?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), $photo->w_title, array('itemprop' => 'contentURL', 'title'=>$photo->w_title))?>
                    <?php else: ?>
                    <?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), '', array('itemprop' => 'contentURL'))?>
                    <?php endif; ?>

                    <meta itemprop="width" content="<?=$photo->width?> px">
                    <meta itemprop="height" content="<?=$photo->height?> px">

                </div>

                <?php if ($photo->w_description): ?>
                <div class="photo-comment" itemprop="description"><?=$photo->w_description?></div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php
//костыль для велентина
if (isset($model->content) && method_exists($model->content, 'isValentinePost') && $model->content->isValentinePost()){
    $post = $model->content;
    $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
        'title' => 'Вам понравилось фото?',
        'notice' => '',
        'model' => $post,
        'type' => 'simple',
        'options' => array(
            'title' => CHtml::encode($post->title),
            'image' => $model->items[0]->photo->getOriginalUrl(),
            'description' => $post->preview,
        ),
    ));

    $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
        'model' => $post,
        'photoContainer'=>true
    ));
}
else {
    $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
        'title' => 'Вам понравилось фото?',
        'notice' => (get_class($model) == 'Contest') ? '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>' : '<big>Рейтинг фото</big><p>Он показывает, насколько нравится ваше фото другим пользователям. Если фото интересное, то пользователи его смотрят, комментируют, увеличивают лайки социальных сетей.</p>',
        'model' => (get_class($model) == 'Contest') ? $photo->getAttachByEntity('ContestWork')->model : $photo,
        'type' => 'simple',
        'options' => array(
            'title' => CHtml::encode($photo->w_title),
            'image' => $photo->getPreviewUrl(180, 180),
            'description' => $photo->w_description,
        ),
    ));

    if (isset($decor)){?>
    <div class="entry-nav clearfix">
        <div class="next">
            <?=$decor->nextLink() ?>
        </div>
        <div class="prev">
            <?=$decor->prevLink() ?>
        </div>
    </div>
    <?php }

    $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
        'model' => $photo,
        'photoContainer'=>true
    ));
}