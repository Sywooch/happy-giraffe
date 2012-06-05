<div id="photo">
    <div class="img">
        <?php echo CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true)); ?>
        <div class="title clearfix">
            <?php if(isset($photo->title) && $photo->title != ''): ?>
            <div class="in">Квашеная капуста с клюквой</div>
            <?php endif; ?>
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $photo->author,
                'size' => 'small',
                'sendButton' => false,
                'location' => false
            )); ?>
        </div>
    </div>
    <a href="javascript:;" class="prev">предыдушая</a>
    <a href="javascript:;" class="next">следующая</a>
</div>
<input type="hidden" id="photo-item-id" value="<?php echo $photo->primaryKey; ?>" />

    <div id="photo-content">
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
        'title' => 'Вам понравилось фото?',
        'type' => 'minimize',
        'model' => $photo,
        'options' => array(
            'title' => $photo->description,
            'image' => $photo->getPreviewUrl(180, 180),
            'description' => false,
        ),
    )); ?>

    <?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
        'model' => $photo,
    )); ?>
</div>