<noindex>
    <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
    'title' => $service->title,
    'notice' => '',
    'model' => $service,
    'type' => 'simple',
    'options' => array(
        'title' => $service->title,
        'image' => '/',
        'description' => $service->description,
    ),
)); ?>
</noindex>