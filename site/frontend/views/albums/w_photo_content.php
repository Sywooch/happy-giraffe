<div id="photo-content">
    <?php if (get_class($model) == 'Contest'): ?>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилось фото?',
            'notice' => '<big>Рейтинг фото</big><p>Он показывает, насколько нравится ваше фото другим пользователям. Если фото интересное, то пользователи его смотрят, комментируют, увеличивают лайки социальных сетей.</p>',
            'model' => $photo->getAttachByEntity('ContestWork')->model,
            'type' => 'simple',
            'options' => array(
                'title' => CHtml::encode($photo->w_title),
                'image' => $photo->getPreviewUrl(180, 180),
                'description' => $photo->w_description,
            ),
        ));  ?>
    <?php endif; ?>

    <?php
        //Yii::import('site.common.models.forms.PhotoViewComment');
    ?>
    <?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
        'model' => $photo,
        'popUp' => true,
        //'commentModel' => 'PhotoViewComment',
    )); ?>
</div>