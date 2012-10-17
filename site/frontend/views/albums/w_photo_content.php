<div id="photo-content">
    <?php if (get_class($model) == 'Contest'): ?>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилось фото?',
            'notice' => '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>',
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