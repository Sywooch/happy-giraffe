<?php
/**
 * @var AttachPhoto $attach
 */
?>

<div class="photo-window-contest-meter">
    <div class="photo-window-contest-meter_count">
        <div class="photo-window-contest-meter_num"><?=$attach->model->rate?></div>
        <div class="photo-window-contest-meter_ball">баллов</div>
    </div>
    <div class="photo-window-contest-meter_vote">
        <div class="photo-window-contest-meter_vote-tx">Голосовать!</div>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'title' => 'Вам понравилось фото?',
            'notice' => '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>',
            'model' => $attach->model,
            'type' => 'simple',
            'options' => array(
                'title' => CHtml::encode($attach->photo->w_title),
                'image' => $attach->photo->getPreviewUrl(180, 180),
                'description' => $attach->photo->w_description,
            ),
        ));  ?>
    </div>
</div>

