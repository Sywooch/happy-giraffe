<div class="b-article clearfix">
    <div class="float-l">
        <div class="like-control like-control__small-indent clearfix">
            <?php $this->widget('UserAvatarWidget', array('user' => $data->author)); ?>
        </div>
        <div class="like-control clearfix">
            <a href="javascript:void(0)" class="like-control_ico like-control_ico__like<?php if (Yii::app()->user->getModel()->isLiked($data)) echo ' active'; ?>" onclick="HgLike(this, 'Album', <?=$data->id ?>);"><?=PostRating::likesCount($data)?></a>
            <?php $this->widget('FavouriteWidget', array('model' => $data, 'right' => true)); ?>
        </div>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="meta-gray">
                <a href="<?=$data->getUrl(true)?>" class="meta-gray_comment">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx"><?=$data->commentsCount?></span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($data->getUrl())?></span>
                </div>
            </div>
            <div class="float-l">
                <a href="<?=$data->author->getUrl()?>" class="b-article_author"><?=$data->author->getFullName()?></a>
                <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created)?></span>
            </div>
        </div>
        <h2 class="b-article_t">
            <a href="<?=$this->createUrl('view', array('albumId' => $data->id))?>" class="b-article_t-a"><?=$data->title?></a>
        </h2>
        <div class="b-article_in clearfix">
            <?php if ($data->description): ?>
            <div class="wysiwyg-content clearfix">
                <p><?=$data->description?></p>
            </div>
            <?php endif; ?>

            <?php
            $this->widget('PhotoCollectionViewWidget', array(
                'collection' => new AlbumPhotoCollection(array('albumId' => $data->id)),
                'width' => 580,
            ));
            ?>
        </div>
        <div class="textalign-r">
            <a href="" class="b-article_more">Смотреть 25 фото</a>
        </div>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data, 'full' => $full)); ?>
    </div>
</div>