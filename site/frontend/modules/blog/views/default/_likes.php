<?php
/**
 * @var HController $this
 * @var CommunityContent $data
 */
?>

<?php if (! Yii::app()->user->checkAccess('tester')): ?>
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
<?php else: ?>
    <div style="text-align: center; margin-bottom: 10px;">
        <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $data)); ?>
    </div>
<?php endif; ?>