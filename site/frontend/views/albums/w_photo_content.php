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
    <?php
    Yii::import('site.common.models.forms.PhotoViewComment');
    ?>
    <?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
        'model' => $photo,
        'popUp' => true,
        'commentModel' => 'PhotoViewComment',
    )); ?>
</div>