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

        <?php if ($photo->author_id == Yii::app()->user->id): ?>
            <?php
                $url = Yii::app()->createAbsoluteUrl('albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $model->id, 'photo_id' => $photo->id));
            ?>
            <div class="sharelink-friends">
                <div class="title-row">
                    Отправить ссылку друзьям
                    <input type="text" class="text" value="<?=$url?>" onclick="$(this).select();" />
                </div>
                <p>Хочешь победить в конкурсе? Разошли эту ссылку друзьям и знакомым, сделай подписью в скайпе, аське и статусом в социальных сетях. Чем больше человек проголосует за твоё фото - тем выше шансы на победу!</p>

            </div>
        <?php endif; ?>
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