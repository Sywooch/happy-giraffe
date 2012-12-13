<noindex>
    <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
    'title' => $service->title,
    'notice' => '',
    'model' => $service,
    'type' => 'simple_socials',
    'options' => array(
        'title' => $service->title,
        'image' => $image,
        'description' => $description,
    ),
)); ?>
</noindex>