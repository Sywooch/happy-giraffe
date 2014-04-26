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
        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
        <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,odnoklassniki,facebook,twitter,moimir,gplus" data-yashareTheme="counter"></div>
    </div>
<?php endif; ?>