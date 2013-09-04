<?php if (false):?>
    <div class="custom-likes-b custom-likes-b__like-white">
        <div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
        <a class="custom-like" href="">
            <span class="custom-like_icon odkl"></span>
            <span class="custom-like_value">0</span>
        </a>
        <a class="custom-like" href="">
            <span class="custom-like_icon vk"></span>
            <span class="custom-like_value">1900</span>
        </a>

        <a class="custom-like" href="">
            <span class="custom-like_icon fb"></span>
            <span class="custom-like_value">150</span>
        </a>

        <a class="custom-like" href="">
            <span class="custom-like_icon tw"></span>
            <span class="custom-like_value">10</span>
        </a>
    </div>
<?php endif ?>

<noindex>
    <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
        'model' => $data,
        'type' => 'simple',
        'options' => array(
            'title' => $data->title,
            'image' => $data->getContentImage(400),
            'description' => $data->preview,
        ),
    )); ?>
</noindex>