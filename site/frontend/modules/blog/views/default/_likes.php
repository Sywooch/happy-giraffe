<?php
/**
 * @var HController $this
 * @var CommunityContent $data
 */
?>


<noindex>
    <?php if (! Yii::app()->user->checkAccess('tester')): ?>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
            'model' => $data,
            'type' => 'simple',
            'options' => array(
                'title' => $data->title,
                'image' => $data->getContentImage(400),
                'description' => $data->preview,
            ),
        )); ?>
    <?php endif; ?>
    <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $data)); ?>

</noindex>
