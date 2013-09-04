<div class="b-article clearfix">
    <div class="float-l">
        <div class="like-control like-control__small-indent clearfix">
            <?php $this->widget('Avatar', array('user' => $model->author)); ?>
        </div>
        <div class="like-control clearfix">
            <?php $this->widget('application.modules.blog.widgets.LikeWidget', array('model' => $model)); ?>
            <?php $this->widget('FavouriteWidget', array('model' => $model, 'right' => true)); ?>
        </div>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="meta-gray">
                <a href="<?=$model->getUrl(true)?>" class="meta-gray_comment">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx"><?=$model->commentsCount?></span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($model->getUrl())?></span>
                </div>
            </div>
            <div class="float-l">
                <a href="<?=$model->author->getUrl()?>" class="b-article_author"><?=$model->author->getFullName()?></a>
                <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created)?></span>
            </div>
        </div>
        <h1 class="b-article_t">
            <a href="<?=$model->url?>" class="b-article_t-a"><?=$model->title?></a>
        </h1>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <div class="b-article_in-img">
                    <?=CHtml::image($model->getPreviewUrl(580, null, Image::WIDTH), $model->title, array('class' => 'content-img'))?>
                </div>
            </div>
        </div>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $model, 'full' => false)); ?>
    </div>
</div>