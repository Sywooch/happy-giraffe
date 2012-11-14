<div class="like-block fast-like-block">

    <div class="box-1">
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
        'model' => $model,
        'type' => '3_btns',
        'options' => array(
            'title' => $this->social_title,
            'image' => '/images/widget/horoscope/big/'.$model->zodiac.'.jpg',
            'description' => Str::truncate($model->text, 250),
        ),
    )); ?>
    </div>

</div>